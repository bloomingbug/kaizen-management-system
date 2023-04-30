<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Kaizen;
use App\Models\Status;
use App\Models\Category;
use App\Models\Departement;
use App\Models\Signature;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Models\Role;
use Inertia\Testing\AssertableInertia;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SignatureControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        Status::create([
            'name' => 'Terkirim',
            'description' => $this->faker()->text(),
        ]);
    }

    /** @test */
    public function user_can_view_signature_page()
    {
        $permissions = [
            Permission::create(['name' => 'kaizen.index', 'guard_name' => 'web']),
            Permission::create(['name' => 'kaizen.pic', 'guard_name' => 'web']),
        ];

        $role = Role::create(['name' => 'test']);
        $role->givePermissionTo($permissions);

        $user = User::factory()->create();
        $user->assignRole($role);

        $this->actingAs($user);

        $departement = Departement::create(['name' => 'test']);
        $category = Category::create(['name' => 'test']);

        $name = $this->faker->name;
        Storage::fake('kaizens');
        $image = UploadedFile::fake()->image('kaizen.jpg', 100, 100)->size(2048);

        $this->post(route('kaizens.store'), [
            'departement_id' => $departement->id,
            'category_id' => $category->id,
            'name' => $name,
            'description_old' => $this->faker->text,
            'description_new' => $this->faker->text,
            'image_old' => $image,
            'image_new' => $image,
            'benefit' => $this->faker->text,
        ])->assertStatus(302)->assertSessionHas('success');

        $status = Status::create([
            'name' => $this->faker()->name(),
            'description' => $this->faker()->text(),
        ]);

        $kaizen = Kaizen::where('name', $name)->first();

        $this->put(route('kaizens.update.pic', $kaizen->id), [
            'review_pic' => $this->faker->text,
            'point_pic' => $this->faker->numberBetween(0, 100),
            'status_pic_id' => $status->id,
        ])->assertStatus(302)->assertSessionHas('success');

        $kaizen = Kaizen::where('name', $name)->first();

        $signature = Signature::where('id', $kaizen->pic_id)->first();
        $response = $this->get(route('signatures.show', $signature->id));
        $response->assertStatus(200);
        $response->assertOk();
        $response->assertInertia(
            fn (AssertableInertia $page) => $page
                ->component('Signature/Show')
                ->has('signature')
                ->has('signature.user')
                ->has('dokumen')
        );

        $this->assertDatabaseCount('kaizens', 1);
        $this->assertDatabaseCount('signatures', 1);

        $response = $this->put(route('kaizens.update.pic', $kaizen->no), [
            'review_pic' => $this->faker->text,
            'point_pic' => $this->faker->numberBetween(0, 100),
            'status_pic_id' => $status->id,
        ]);

        $this->assertDatabaseCount('signatures', 1);
    }

    /** @test */
    public function user_cant_view_signature_page()
    {
        $response = $this->get(route('signatures.show', 1));
        $response->assertStatus(404);
        $response->assertNotFound();
    }
}
