<?php

namespace Tests\Feature;

use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Inertia\Testing\AssertableInertia as Assert;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $permissions = [];

    protected User $userHavePermission;

    protected User $userNotHavePermission;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();

        $this->userHavePermission = User::factory()->create();

        $this->userNotHavePermission = User::factory()->create();

        array_push($this->permissions, Permission::create(['name' => 'role.index', 'guard_name' => 'web']));
        array_push($this->permissions, Permission::create(['name' => 'role.create', 'guard_name' => 'web']));
        array_push($this->permissions, Permission::create(['name' => 'role.edit', 'guard_name' => 'web']));
        array_push($this->permissions, Permission::create(['name' => 'role.delete', 'guard_name' => 'web']));

        $role = Role::create(['name' => 'test']);
        $role->givePermissionTo($this->permissions);
        $this->userHavePermission->assignRole($role);

        
    }

    /** @test */
    public function user_can_view_role_index_page()
    {
        // Insert 9 rendom data to role without factory
        for ($i = 0; $i < 9; $i++) {
            $name = $this->faker->word;
            // check name is Already exist
            if (Role::where('name', $name)->get()->count() > 0) {
                $i--;
                continue;
            }
            Role::create(['name' => $name, 'guard_name' => 'web']);
        }

        $this->actingAs($this->userHavePermission);

        $response = $this->get(route('roles.index'));

        $response->assertStatus(200);
        $response->assertInertia(
            fn (Assert $page) => $page
                ->component('Role/Index')
                ->has('roles.data', 5)
                ->where('roles.total', 10)
        );

        // filtered data
        Role::create(['name' => 'match', 'guard_name' => 'web']);
        $response = $this->get(route('roles.index', ['q' => 'match']));
        $response->assertInertia(function (Assert $page) {
            $page->component('Role/Index')
            ->has('roles.data', 1)
            ->where('roles.total', 1)
            ->where('roles.data.0.name', 'match');
        });
    }

    /** @test */
    public function user_cant_view_role_index_page()
    {
        $this->actingAs($this->userNotHavePermission);

        $this->expectException(Exception::class);
        $response = $this->get(route('roles.index'));
        $response->assertStatus(403);
    }

    /** @test */
    public function user_can_view_create_role_page()
    {
        $this->actingAs($this->userHavePermission);

        $response = $this->get(route('roles.create'));
        $response->assertStatus(200);
        $response->assertInertia(
            fn (Assert $page) => $page
                ->component('Role/Create')
                ->has('permissions')
        );
    }

    /** @test */
    public function user_cant_view_create_role_page()
    {
        $this->expectException(Exception::class);

        $this->actingAs($this->userNotHavePermission);
        $response = $this->get(route('roles.create'));
        $response->assertStatus(403);

        $this->actingAs($this->userHavePermission);
        $response = $this->post(route('roles.create'));
        $response->assertStatus(405);
    }

    /** @test */
    public function user_can_create_a_role()
    {
        $this->actingAs($this->userHavePermission);

        $permissions = Permission::all()->pluck('name')->toArray();

        $response = $this->post(route('roles.store'), [
            'name' => 'test tambah role',
            'permissions' => $permissions
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('roles.index'));
        $response->assertSessionHas('success');
        $role = Role::where('name', 'test tambah role')->first();
        $this->assertNotNull($role);
        $this->assertTrue($role->hasAllPermissions($permissions));
        $this->assertDatabaseCount('roles', 2);
    }

    /** @test */
    public function user_cant_create_a_role()
    {
        $this->expectException(Exception::class);

        $this->actingAs($this->userNotHavePermission);
        $response = $this->post(route('roles.store'), [
            'name' => 'test tambah role',
            'permissions' => []
        ]);
        $response->assertStatus(403);
        $role = Role::where('name', 'test tambah role')->first();
        $this->assertNull($role);

        $this->actingAs($this->userHavePermission);
        $this->expectException(Exception::class);
        $response = $this->post(route('roles.store'), [
            'name' => '',
            'permissions' => []
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name', 'permissions']);
    }

    /** @test */
    public function user_can_view_edit_role_page()
    {
        $this->actingAs($this->userHavePermission);

        $role = Role::create(['name' => 'test edit role', 'guard_name' => 'web']);
        $role->givePermissionTo($this->permissions);

        $response = $this->get(route('roles.edit', $role->id));
        $response->assertStatus(200);
        $response->assertInertia(
            fn (Assert $page) => $page
                ->component('Role/Edit')
                ->has('role')
                ->has('permissions')
        );
    }

    /** @test */
    public function user_cant_view_edit_role_page()
    {
        $this->expectException(Exception::class);

        $role = Role::create(['name' => 'test edit role', 'guard_name' => 'web']);
        $role->givePermissionTo($this->permissions);

        $this->actingAs($this->userNotHavePermission);
        $response = $this->get(route('roles.edit', $role->id));
        $response->assertStatus(403);

        $this->actingAs($this->userHavePermission);
        $response = $this->get(route('roles.edit', 999));
        $response->assertStatus(404);

        $response = $this->post(route('roles.edit', $role->id));
        $response->assertStatus(405);
    }

    /** @test */
    public function user_can_edit_a_role()
    {
        $this->actingAs($this->userHavePermission);

        $role = Role::create(['name' => 'test edit role', 'guard_name' => 'web']);
        $role->givePermissionTo($this->permissions);
        $permissions = Permission::all()->pluck('name')->toArray();

        $response = $this->put(route('roles.update', $role->id), [
            'name' => 'test edit role teredit',
            'permissions' => $permissions
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');
        $role = Role::where('name', 'test edit role teredit')->first();
        $this->assertNotNull($role);
    }

    /** @test */
    public function user_cant_edit_a_role()
    {
        $this->expectException(Exception::class);

        $role = Role::create(['name' => 'test edit role', 'guard_name' => 'web']);
        $role->givePermissionTo($this->permissions);
        $permissions = Permission::all()->pluck('name')->toArray();

        $this->actingAs($this->userNotHavePermission);
        $response = $this->put(route('roles.update', $role->id), [
            'name' => 'test edit role teredit',
            'permissions' => $permissions
        ]);
        $response->assertStatus(403);
        $role = Role::where('name', 'test edit role teredit')->first();
        $this->assertNull($role);

        $this->actingAs($this->userHavePermission);
        $response = $this->post(route('roles.update', $role->id), [
            'name' => 'test edit role teredit',
            'permissions' => $permissions
        ]);
        $response->assertStatus(405);
        $role = Role::where('name', 'test edit role teredit')->first();
        $this->assertNull($role);

        $response = $this->put(route('roles.update', 999), [
            'name' => 'test edit role teredit',
            'permissions' => $permissions
        ]);
        $response->assertStatus(404);
        $role = Role::where('name', 'test edit role teredit')->first();
        $this->assertNull($role);

        $response = $this->put(route('roles.update', $role->id), [
            'name' => '',
            'permissions' => []
        ]);
        $response->assertStatus(422);
        $response->assertSessionHasErrors(['name', 'permissions']);
    }

    /** @test */
    public function user_can_delete_a_role()
    {
        $this->actingAs($this->userHavePermission);

        $role = Role::create(['name' => 'test delete role', 'guard_name' => 'web']);
        $role->givePermissionTo($this->permissions);

        $response = $this->delete(route('roles.destroy', $role->id));
        $response->assertStatus(302);
        $response->assertSessionHas('success');
        $this->assertNull(Role::find($role->id));
        $this->assertDatabaseCount('roles', 1);
    }

    /** @test */
    public function user_cant_delete_a_role()
    {
        $this->expectException(Exception::class);

        $role = Role::create(['name' => 'test delete role', 'guard_name' => 'web']);
        $role->givePermissionTo($this->permissions);

        $this->actingAs($this->userNotHavePermission);
        $response = $this->delete(route('roles.destroy', $role->id));
        $response->assertStatus(403);
        $role = Role::where('name', 'test delete role')->first();
        $this->assertNotNull($role);

        $this->actingAs($this->userHavePermission);
        $response = $this->post(route('roles.destroy', $role->id));
        $response->assertStatus(405);
        $role = Role::where('name', 'test delete role')->first();
        $this->assertNotNull($role);

        $response = $this->delete(route('roles.destroy', 999));
        $response->assertStatus(404);
        $role = Role::where('name', 'test delete role')->first();
        $this->assertNotNull($role);
    }
}
