<?php

namespace Tests\Feature;

use App\Models\Departement;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class UserControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $user;

    protected $permissions = [];

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        array_push($this->permissions, Permission::create(['name' => 'user.index', 'guard_name' => 'web']));
        array_push($this->permissions, Permission::create(['name' => 'user.create', 'guard_name' => 'web']));
        array_push($this->permissions, Permission::create(['name' => 'user.edit', 'guard_name' => 'web']));
        array_push($this->permissions, Permission::create(['name' => 'user.delete', 'guard_name' => 'web']));

        $role = Role::create(['name' => 'test']);
        $role->givePermissionTo($this->permissions);
        $this->user->assignRole($role);
    }

    /** @test */
    public function user_can_view_page_login()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertInertia(fn (AssertableInertia $page) => $page->component('Auth/Login'));
    }

    /** @test */
    public function user_cant_view_page_login()
    {
        $response = $this->actingAs($this->user)->get('/login');
        $response->assertStatus(302);
    }

    /** @test */
    public function user_can_login()
    {
        $response = $this->post('/login', [
            'email' => $this->user->email,
            'password' => 'password',
            'remember_me' => true
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('dashboard'));
    }

    /** @test */
    public function user_cant_login()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => ''
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email', 'password']);

        $response = $this->post('/login', [
            'email' => $this->user->email,
            'password' => 'wrong_password'
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function admin_can_view_page_user()
    {
        $response = $this->actingAs($this->user)->get('/admin/users');
        $response->assertStatus(200);
        $response->assertInertia(
            fn (AssertableInertia $page) => $page
                ->component('User/Index')
                ->has('users')
        );
    }

    /** @test */
    public function admin_cant_view_page_user()
    {
        $response = $this->get('/admin/users');
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/admin/users');
        $response->assertStatus(403);
    }

    /** @test */
    public function admin_can_view_page_add_user()
    {
        $response = $this->actingAs($this->user)->get('/admin/users/create');
        $response->assertStatus(200);
        $response->assertInertia(fn (AssertableInertia $page) => $page->component('User/Create')->has('roles')->has('departements'));
    }

    /** @test */
    public function admin_cant_view_page_add_user()
    {
        $response = $this->get('/admin/users/create');
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/admin/users/create');
        $response->assertStatus(403);
    }

    /** @test */
    public function admin_can_add_user()
    {
        $departement = Departement::create(['name' => 'test']);
        $role = Role::all()->pluck('name')->toArray();

        $response = $this->actingAs($this->user)->post('/admin/users', [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'departement_id' => $departement->id,
            'roles' => $role,
            'jabatan' => 'test',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseCount('users', 2);
    }

    /** @test */
    public function admin_cant_add_user()
    {
        $departement = Departement::create(['name' => 'test']);
        $role = Role::all()->pluck('name')->toArray();

        $response = $this->post('/admin/users', [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'departement_id' => $departement->id,
            'roles' => $role,
            'jabatan' => 'test',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/admin/users', [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'departement_id' => $departement->id,
            'roles' => $role,
            'jabatan' => 'test',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);
        $response->assertStatus(403);

        $response = $this->actingAs($this->user)->post('/admin/users', [
            'name' => '',
            'email' => '',
            'departement_id' => '',
            'roles' => '',
            'jabatan' => '',
            'password' => '',
            'password_confirmation' => ''
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name', 'email', 'departement_id', 'roles', 'jabatan', 'password']);
    }

    /** @test */
    public function admin_can_view_page_edit_user()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($this->user)->get('/admin/users/' . $user->id . '/edit');
        $response->assertStatus(200);
        $response->assertInertia(fn (AssertableInertia $page) => $page->component('User/Edit')->has('user')->has('roles')->has('departements'));
    }

    /** @test */
    public function admin_cant_view_page_edit_user()
    {
        $user = User::factory()->create();
        $response = $this->get('/admin/users/' . $user->id . '/edit');
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/admin/users/' . $user->id . '/edit');
        $response->assertStatus(403);

        $response = $this->actingAs($this->user)->get('/admin/users/9999/edit');
        $response->assertStatus(404);
    }

    /** @test */
    public function admin_can_edit_user()
    {
        $user = User::factory()->create();
        $departement = Departement::create(['name' => 'test']);
        $role = Role::all()->pluck('name')->toArray();

        $response = $this->actingAs($this->user)->put('/admin/users/' . $user->id, [
            'name' => $this->faker->name,
            'departement_id' => $departement->id,
            'roles' => $role,
            'jabatan' => 'test',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success');
    }

    /** @test */
    public function admin_cant_edit_user()
    {
        $user = User::factory()->create();
        $departement = Departement::create(['name' => 'test']);
        $role = Role::all()->pluck('name')->toArray();

        $response = $this->put('/admin/users/' . $user->id, [
            'name' => $this->faker->name,
            'departement_id' => $departement->id,
            'roles' => $role,
            'jabatan' => 'test',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        $user = User::factory()->create();
        $response = $this->actingAs($user)->put('/admin/users/' . $user->id, [
            'name' => $this->faker->name,
            'departement_id' => $departement->id,
            'roles' => $role,
            'jabatan' => 'test',
        ]);
        $response->assertStatus(403);

        $response = $this->actingAs($this->user)->put('/admin/users/' . $user->id, [
            'name' => '',
            'departement_id' => '',
            'roles' => '',
            'jabatan' => '',
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name', 'departement_id', 'roles', 'jabatan']);
    }

    /** @test */
    public function admin_can_delete_user()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($this->user)->delete('/admin/users/' . $user->id);
        $response->assertStatus(302);
        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseCount('users', 1);
    }

    /** @test */
    public function admin_cant_delete_user()
    {
        $user = User::factory()->create();
        $response = $this->delete('/admin/users/' . $user->id);
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        $user = User::factory()->create();
        $response = $this->actingAs($user)->delete('/admin/users/' . $user->id);
        $response->assertStatus(403);

        $response = $this->actingAs($this->user)->delete('/admin/users/9999');
        $response->assertStatus(404);
    }

    /** @test */
    public function admin_can_view_page_change_password()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($this->user)->get('/admin/users/change-password/' . $user->id . '/edit');
        $response->assertStatus(200);
        $response->assertInertia(fn (AssertableInertia $page) => $page->component('User/ChangePassword')->has('user'));
    }

    /** @test */
    public function admin_cant_view_page_change_password()
    {
        $user = User::factory()->create();
        $response = $this->get('/admin/users/change-password/' . $user->id . '/edit');
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/admin/users/change-password/' . $user->id . '/edit');
        $response->assertStatus(403);

        $response = $this->actingAs($this->user)->get('/admin/users/change-password/9999/edit');
        $response->assertStatus(404);
    }

    /** @test */
    public function admin_can_change_password()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($this->user)->put('/admin/users/update-password/' . $user->id, [
            'current_password' => 'password',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success');
    }

    /** @test */
    public function admin_cant_change_password()
    {
        $user = User::factory()->create();
        $response = $this->put('/admin/users/update-password/' . $user->id, [
            'current_password' => 'password',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        $user = User::factory()->create();
        $response = $this->actingAs($user)->put('/admin/users/update-password/' . $user->id, [
            'current_password' => 'password',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);
        $response->assertStatus(403);

        $response = $this->actingAs($this->user)->put('/admin/users/update-password/' . $user->id, [
            'current_password' => '',
            'password' => '',
            'password_confirmation' => ''
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['current_password', 'password']);
    }
}
