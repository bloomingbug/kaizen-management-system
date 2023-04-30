<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Status;
use App\Models\Category;
use App\Models\Departement;
use App\Models\Kaizen;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Models\Role;
use Inertia\Testing\AssertableInertia;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class KaizenControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $user;
    protected Category $category;
    protected Departement $departement;
    protected Kaizen $kaizen;

    public function setUp(): void
    {
        parent::setUp();

        Status::create([
            'name' => 'Terkirim',
            'description' => $this->faker()->text(),
        ]);

        $permissions = [
            Permission::create(['name' => 'kaizen.index', 'guard_name' => 'web']),
            Permission::create(['name' => 'kaizen.create', 'guard_name' => 'web']),
            Permission::create(['name' => 'kaizen.show', 'guard_name' => 'web']),
            Permission::create(['name' => 'kaizen.delete', 'guard_name' => 'web']),
            Permission::create(['name' => 'kaizen.pic', 'guard_name' => 'web']),
            Permission::create(['name' => 'kaizen.secretary', 'guard_name' => 'web']),
        ];

        $role = Role::create(['name' => 'test']);
        $role->givePermissionTo($permissions);

        $this->user = User::factory()->create();
        $this->user->assignRole($role);

        $this->category = Category::create(['name' => 'test']);
        $this->departement = Departement::create(['name' => 'test']);

        $name = $this->faker()->name();
        $this->post(route('kaizens.store'), [
            'departement_id' => $this->departement->id,
            'category_id' => $this->category->id,
            'name' => $name,
            'description_old' => $this->faker->text,
            'description_new' => $this->faker->text,
            'benefit' => $this->faker->text,
        ]);

        $this->kaizen = Kaizen::where('name', $name)->first();
    }

    /** @test */
    public function user_can_view_form_add_kaizen()
    {
        $this->get(route('kaizens.form'))
            ->assertStatus(200)
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Kaizen/Create')
                    ->has('categories')
                    ->has('departements')
            );
    }

    /** @test */
    public function user_can_add_kaizen()
    {
        $name = $this->faker->name;
        Storage::fake('kaizens');
        $image = UploadedFile::fake()->image('kaizen.jpg', 100, 100)->size(2048);

        $response = $this->post(route('kaizens.store'), [
            'departement_id' => $this->departement->id,
            'category_id' => $this->category->id,
            'name' => $name,
            'description_old' => $this->faker->text,
            'description_new' => $this->faker->text,
            'image_old' => $image,
            'image_new' => $image,
            'benefit' => $this->faker->text,
        ]);

        $kaizen = Kaizen::where('name', $name)->first();

        $response->assertStatus(302);
        $response->assertRedirect(route('kaizens.details', $kaizen->id));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('kaizens', [
            'name' => $name,
        ]);
    }

    /** @test */
    public function user_cant_add_kaizen()
    {
        $this->post(route('kaizens.store'), [
            'departement_id' => '',
            'category_id' => '',
            'name' => '',
            'description_old' => $this->faker->text,
            'description_new' => $this->faker->text,
            'benefit' => $this->faker->text,
        ])->assertStatus(302)->assertSessionHasErrors([
            'departement_id',
            'category_id',
            'name',
        ]);

        // rate limiting (3) test, 4th request will be failed, but 1st request in setUp()
        for ($i = 0; $i < 2; $i++) {
            $name = $this->faker()->name();
            $response = $this->post(route('kaizens.store'), [
                'departement_id' => $this->departement->id,
                'category_id' => $this->category->id,
                'name' => $name,
                'description_old' => $this->faker->text,
                'description_new' => $this->faker->text,
                'benefit' => $this->faker->text,
            ]);

            $kaizen = Kaizen::where('name', $name)->first();

            $response->assertSessionHas('success')->assertRedirect(route('kaizens.details', $kaizen->id));
        }

        $response = $this->post(route('kaizens.store'), [
            'departement_id' => $this->departement->id,
            'category_id' => $this->category->id,
            'name' => $this->faker()->name(),
            'description_old' => $this->faker->text,
            'description_new' => $this->faker->text,
            'benefit' => $this->faker->text,
        ]);
        $response->assertRedirect();
        $response->assertSessionHas('error');

        $this->assertDatabaseCount('kaizens', 3);
    }

    /** @test */
    public function user_can_view_kaizen_details()
    {
        $this->get(route('kaizens.details', $this->kaizen->id))
            ->assertStatus(200)
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Kaizen/Detail')
                    ->has('kaizen')
            );
    }

    public function user_cant_view_Kaizen_details()
    {
        $this->get(route('kaizens.details', 1))
            ->assertStatus(404);
    }

    /** @test */
    public function admin_can_view_page_index()
    {
        $this->actingAs($this->user);

        $this->get(route('kaizens.index'))
            ->assertStatus(200)
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Kaizen/Index')
                    ->has('kaizens')
            );

        $this->get(route('kaizens.index', [
            'q' => $this->kaizen->name
        ]))
            ->assertStatus(200)
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Kaizen/Index')
                    ->has('kaizens')
            );
    }

    /** @test */
    public function admin_cant_view_page_index()
    {
        $this->get(route('kaizens.index'))
            ->assertStatus(302)
            ->assertRedirect(route('login'));

        $user = User::factory()->create();
        $this->actingAs($user)->get(route('kaizens.index'))
            ->assertStatus(403);
    }

    /** @test */
    public function admin_can_view_page_show()
    {
        $this->actingAs($this->user)->get(route('kaizens.show', $this->kaizen->id))
            ->assertStatus(200)
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Kaizen/Show')
                    ->has('kaizen')
            );
    }

    /** @test */
    public function admin_cant_view_page_show()
    {
        $this->get(route('kaizens.show', $this->kaizen->id))
            ->assertStatus(302)
            ->assertRedirect(route('login'));

        $this->actingAs($this->user)->get(route('kaizens.show', 1))->assertStatus(404)->assertNotFound();

        $user = User::factory()->create();
        $this->actingAs($user)->get(route('kaizens.show', $this->kaizen->id))
            ->assertStatus(403);
    }

    /** @test */
    public function admin_can_view_page_update_sign_pic()
    {
        $this->actingAs($this->user)->get(route('kaizens.pic', $this->kaizen->id))
            ->assertStatus(200)
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Kaizen/SignPic')
                    ->has('kaizen')
            );
    }

    /** @test */
    public function admin_cant_view_page_update_sign_pic()
    {
        $this->get(route('kaizens.pic', $this->kaizen->id))
            ->assertStatus(302)
            ->assertRedirect(route('login'));

        $this->actingAs($this->user)->get(route('kaizens.pic', 1))->assertStatus(404)->assertNotFound();

        $user = User::factory()->create();
        $this->actingAs($user)->get(route('kaizens.pic', $this->kaizen->id))
            ->assertStatus(403);
    }

    /** @test */
    public function admin_can_update_sign_pic()
    {
        $status = Status::create([
            'name' => 'Approved',
            'description' => $this->faker()->text(),
        ]);

        $this->actingAs($this->user)->put(route('kaizens.update.pic', $this->kaizen->id), [
            'review_pic' => $this->faker->text,
            'point_pic' => $this->faker->numberBetween(0, 100),
            'status_pic_id' => $status->id,
        ])->assertStatus(302)->assertRedirect(route('kaizens.index'))->assertSessionHas('success');
    }

    /** @test */
    public function admin_cant_update_sign_pic()
    {
        $status = Status::create([
            'name' => 'Approved',
            'description' => $this->faker()->text(),
        ]);

        $this->put(route('kaizens.update.pic', $this->kaizen->id), [
            'review_pic' => $this->faker->text,
            'point_pic' => $this->faker->numberBetween(0, 100),
            'status_pic_id' => $status->id,
        ])->assertStatus(302)->assertRedirect(route('login'));

        $this->actingAs($this->user)->put(route('kaizens.update.pic', $this->kaizen->id), [
            'review_pic' => '',
            'point_pic' => $this->faker->text(),
            'status_pic_id' => 999,
        ])->assertStatus(302)->assertSessionHasErrors(['review_pic', 'point_pic', 'status_pic_id']);

        $user = User::factory()->create();
        $this->actingAs($user)->put(route('kaizens.update.pic', $this->kaizen->id), [
            'review_pic' => $this->faker->text,
            'point_pic' => $this->faker->numberBetween(0, 100),
            'status_pic_id' => $status->id,
        ])->assertStatus(403)->assertForbidden();

        $this->actingAs($this->user)->put(route('kaizens.update.pic', 999), [
            'review_pic' => $this->faker->text,
            'point_pic' => $this->faker->numberBetween(0, 100),
            'status_pic_id' => $status->id,
        ])->assertStatus(404)->assertNotFound();
    }

    /** @test */
    public function admin_can_view_page_update_sign_secretary()
    {
        $status = Status::create([
            'name' => 'Approved',
            'description' => $this->faker()->text(),
        ]);

        $this->actingAs($this->user)->put(route('kaizens.update.pic', $this->kaizen->id), [
            'review_pic' => $this->faker->text,
            'point_pic' => $this->faker->numberBetween(0, 100),
            'status_pic_id' => $status->id,
        ])->assertStatus(302)->assertRedirect(route('kaizens.index'))->assertSessionHas('success');

        $this->actingAs($this->user)->get(route('kaizens.secretary', $this->kaizen->id))
            ->assertStatus(200)
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Kaizen/SignSecretary')
                    ->has('kaizen')
            );
    }

    /** @test */
    public function admin_cant_view_page_update_sign_secretary()
    {
        $this->get(route('kaizens.secretary', $this->kaizen->id))
            ->assertStatus(302)
            ->assertRedirect(route('login'));

        $this->actingAs($this->user)->get(route('kaizens.secretary', 1))->assertStatus(404)->assertNotFound();

        $this->actingAs($this->user)->get(route('kaizens.secretary', $this->kaizen->id))->assertStatus(302)->assertSessionHas('error', 'Kaizen belum ditandatangani oleh PIC');

        $user = User::factory()->create();
        $this->actingAs($user)->get(route('kaizens.secretary', $this->kaizen->id))
            ->assertStatus(403);
    }

    /** @test */
    public function admin_can_update_sign_secretary()
    {
        $status = Status::create([
            'name' => 'Approved',
            'description' => $this->faker()->text(),
        ]);

        $this->actingAs($this->user)->put(route('kaizens.update.pic', $this->kaizen->id), [
            'review_pic' => $this->faker->text,
            'point_pic' => $this->faker->numberBetween(0, 100),
            'status_pic_id' => $status->id,
        ])->assertStatus(302)->assertRedirect(route('kaizens.index'))->assertSessionHas('success');

        $this->actingAs($this->user)->put(route('kaizens.update.secretary', $this->kaizen->id), [
            'review_secretary' => $this->faker->text,
            'point_secretary' => $this->faker->numberBetween(0, 100),
            'status_secretary_id' => $status->id,
        ])->assertStatus(302)->assertRedirect(route('kaizens.index'))->assertSessionHas('success');
    }

    public function admin_cant_update_sign_secretary()
    {
        $status = Status::create([
            'name' => 'Approved',
            'description' => $this->faker()->text(),
        ]);

        $this->actingAs($this->user)->put(route('kaizens.update.secretary', $this->kaizen->id), [
            'review_secretary' => $this->faker->text,
            'point_secretary' => $this->faker->numberBetween(0, 100),
            'status_secretary_id' => $status->id,
        ])->assertStatus(302)->assertSessionHas('error', 'Kaizen belum ditandatangani oleh PIC');

        $status = Status::create([
            'name' => 'Approved',
            'description' => $this->faker()->text(),
        ]);

        $this->put(route('kaizens.update.secretary', $this->kaizen->id), [
            'review_secretary' => $this->faker->text,
            'point_secretary' => $this->faker->numberBetween(0, 100),
            'status_secretary_id' => $status->id,
        ])->assertStatus(302)->assertRedirect(route('login'));

        $this->actingAs($this->user)->put(route('kaizens.update.secretary', 999), [
            'review_secretary' => $this->faker->text,
            'point_secretary' => $this->faker->numberBetween(0, 100),
            'status_secretary_id' => $status->id,
        ])->assertStatus(404)->assertNotFound();

        $this->actingAs($this->user)->put(route('kaizens.update.pic', $this->kaizen->id), [
            'review_pic' => $this->faker->text,
            'point_pic' => $this->faker->numberBetween(0, 100),
            'status_pic_id' => $status->id,
        ])->assertStatus(302)->assertRedirect(route('kaizens.index'))->assertSessionHas('success');

        $user = User::factory()->create();
        $this->actingAs($user)->put(route('kaizens.update.secretary', $this->kaizen->id), [
            'review_secretary' => $this->faker->text,
            'point_secretary' => $this->faker->numberBetween(0, 100),
            'status_secretary_id' => $status->id,
        ])->assertStatus(403)->assertForbidden();

        $this->actingAs($this->user)->put(route('kaizens.update.secretary', $this->kaizen->id), [
            'review_secretary' => '',
            'point_secretary' => $this->faker->text(),
            'status_secretary_id' => 999,
        ])->assertStatus(302)->assertSessionHasErrors(['review_secretary', 'point_secretary', 'status_secretary_id']);
    }

    /** @test */
    public function admin_can_destroy_kaizen()
    {
        $this->actingAs($this->user)->delete(route('kaizens.destroy', $this->kaizen->id))->assertStatus(302)->assertRedirect(route('kaizens.index'))->assertSessionHas('success');

        $this->assertDatabaseCount('kaizens', 0);
    }

    /** @test */
    public function admin_cant_destroy_kaizen()
    {
        $this->delete(route('kaizens.destroy', $this->kaizen->id))->assertStatus(302)->assertRedirect(route('login'));

        $this->actingAs($this->user)->delete(route('kaizens.destroy', 999))->assertStatus(404)->assertNotFound();

        $user = User::factory()->create();
        $this->actingAs($user)->delete(route('kaizens.destroy', $this->kaizen->id))->assertStatus(403)->assertForbidden();
    }

    public function user_can_print_pdf()
    {
        $this->get(route('kaizens.print', $this->kaizen->id))->assertStatus(200)->assertOk();
    }

    public function user_cant_print_pdf()
    {

        $this->get(route('kaizens.print', 999))->assertStatus(404)->assertNotFound();
    }
}
