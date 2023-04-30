<?php

namespace Tests\Feature;

use App\Models\Departement;
use Tests\TestCase;
use App\Models\User;
use Exception;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Inertia\Testing\AssertableInertia;

class DepartementControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $user;
    protected $arrayPermissions = [];

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        array_push($this->arrayPermissions, Permission::create(['name' => 'departement.index', 'guard_name' => 'web']));
        array_push($this->arrayPermissions, Permission::create(['name' => 'departement.create', 'guard_name' => 'web']));
        array_push($this->arrayPermissions, Permission::create(['name' => 'departement.edit', 'guard_name' => 'web']));
        array_push($this->arrayPermissions, Permission::create(['name' => 'departement.delete', 'guard_name' => 'web']));

        $role = Role::create(['name' => 'test']);
        $role->givePermissionTo($this->arrayPermissions);
        $this->user->assignRole($role);
    }

    /** @test */
    public function user_can_view_page_index()
    {
        // Insert 10 rendom data to departement without factory
        for ($i = 0; $i < 10; $i++) {
            $name = $this->faker->name;
            // check name is Already exist
            if (Departement::where('name', $name)->get()->count() > 0) {
                $i--;
                continue;
            }
            Departement::create(['name' => $name]);
        }

        $this->actingAs($this->user);
        $response = $this->get(route('departements.index'));
        $response->assertStatus(200);
        $response->assertInertia(
            fn (AssertableInertia $page) => $page
                ->component('Departement/Index')
                ->has('departements')
                ->has('departements.data', 5)
                ->where('departements.total', 10)
        );
    }

    /** @test */
    public function user_cant_view_page_index()
    {
        $response = $this->get(route('departements.index'));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('departements.index'));
        $response->assertStatus(403);
        $response->assertForbidden();
    }

    /** @test */
    public function user_can_view_page_create()
    {
        $response = $this->actingAs($this->user)->get(route('departements.create'));
        $response->assertStatus(200);
        $response->assertOk();
        $response->assertInertia(
            fn (AssertableInertia $page) => $page
                ->component('Departement/Create')
        );
    }

    /** @test */
    public function user_cant_view_page_create()
    {
        $response = $this->get(route('departements.create'));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('departements.create'));
        $response->assertStatus(403);

        $this->actingAs($this->user);
        $response = $this->post(route('departements.create'));
        $response->assertStatus(405);
    }

    /** @test */
    public function user_can_create_departement()
    {
        $this->actingAs($this->user);
        $response = $this->post(route('departements.store'), ['name' => $this->faker->name]);
        $response->assertStatus(302);
        $response->assertRedirect(route('departements.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseCount('departements', 1);
    }

    /** @test */
    public function user_cant_create_departement()
    {
        $response = $this->post(route('departements.store'), ['name' => $this->faker->name]);
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->post(route('departements.store'), ['name' => $this->faker->name]);
        $response->assertStatus(403);

        $this->actingAs($this->user);
        $response = $this->post(route('departements.store'), ['name' => '']);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name']);

        $this->post(route('departements.store'), ['name' => 'test']);
        $response = $this->actingAs($this->user)->post(route('departements.store'), ['name' => 'test']);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function user_can_view_page_edit()
    {
        $departement = Departement::create(['name' => 'test']);
        $response = $this->actingAs($this->user)->get(route('departements.edit', $departement->id));
        $response->assertStatus(200);
        $response->assertOk();
        $response->assertInertia(
            fn (AssertableInertia $page) => $page
                ->component('Departement/Edit')
                ->has('departement')
        );
    }

    /** @test */
    public function user_cant_view_page_edit()
    {
        $departement = Departement::create(['name' => 'test']);
        $response = $this->get(route('departements.edit', $departement->id));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('departements.edit', $departement->id));
        $response->assertStatus(403);

        $this->actingAs($this->user);
        $response = $this->post(route('departements.edit', $departement->id));
        $response->assertStatus(405);

        $response = $this->get(route('departements.edit', 999));
        $response->assertStatus(404);
        $response->assertNotFound();
    }

    /** @test */
    public function user_can_edit_departement()
    {
        $this->actingAs($this->user);
        $departement = Departement::create(['name' => 'test']);
        $response = $this->put(route('departements.update', $departement->id), ['name' => 'test edit']);
        $response->assertStatus(302);
        $response->assertRedirect(route('departements.index'));
        $response->assertSessionHas('success');
    }

    /** @test */
    public function user_cant_edit_departement()
    {
        $departement = Departement::create(['name' => 'test']);

        $response = $this->put(route('departements.update', $departement->id), ['name' => 'test edit']);
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        $user = User::factory()->create();
        $response = $this->actingAs($user)->put(route('departements.update', $departement->id), ['name' => 'test edit']);
        $response->assertStatus(403);
        $response->assertForbidden();

        $response = $this->actingAs($this->user)->put(route('departements.update', 999), ['name' => 'test edit']);
        $response->assertStatus(404);
        $response->assertNotFound();

        $response = $this->actingAs($this->user)->put(route('departements.update', $departement->id), ['name' => '']);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function user_can_delete_departement()
    {
        $departement = Departement::create(['name' => 'test']);
        $response = $this->actingAs($this->user)->delete(route('departements.destroy', $departement->id));
        $response->assertStatus(302);
        $response->assertRedirect(route('departements.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseCount('departements', 0);
    }

    /** @test */
    public function user_cant_delete_departement()
    {
        $departement = Departement::create(['name' => 'test']);
        $user = User::factory()->create();

        $response = $this->delete(route('departements.destroy', $departement->id));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        $response = $this->actingAs($user)->delete(route('departements.destroy', $departement->id));
        $response->assertStatus(403);
        $response->assertForbidden();

        $response = $this->actingAs($this->user)->delete(route('departements.destroy', 999));
        $response->assertStatus(404);
        $response->assertNotFound();
    }
}
