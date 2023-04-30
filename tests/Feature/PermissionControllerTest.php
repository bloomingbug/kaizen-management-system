<?php

namespace Tests\Feature;

use Exception;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermissionControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $model = Permission::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->model::create(['name' => 'permission.index', 'guard_name' => 'web']);
    }

    /** @test */
    public function success_to_access_with_permission_index()
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'test']);
        $role->givePermissionTo($this->model::first());
        $user->assignRole($role);

        $this->actingAs($user);
        $response = $this->get('/admin/permissions');

        $response->assertStatus(200);
    }

    /** @test */
    public function failed_to_access_without_permission_index()
    {
        $this->actingAs(User::factory()->create());
        $this->expectException(Exception::class);
        $response = $this->get('/admin/permissions');

        $response->assertStatus(403);
    }

    /** @test */
    public function it_should_return_the_permissions_with_latest_order_and_paginate_by_five()
    {
        for ($i = 0; $i < 9; $i++) {
            $name = $this->faker->word;
            // check name is Already exist
            if ($this->model::where('name', $name)->get()->count() > 0) {
                $i--;
                continue;
            }

            $this->model::create(['name' => $name, 'guard_name' => 'web']);
        }

        $user = User::factory()->create();
        $role = Role::create(['name' => 'test']);
        $role->givePermissionTo('permission.index');
        $user->assignRole($role);

        $this->actingAs($user);

        $response = $this->get('/admin/permissions');

        $response->assertInertia(function (Assert $page) {
            $page->component('Permission/Index')
                ->has('permissions.data', 5)
                ->where('permissions.total', 10);
        });
    }

    /** @test */
    public function it_should_return_the_filtered_permissions()
    {
        $this->model::create(['name' => 'matching_permission', 'guard_name' => 'web']);

        $user = User::factory()->create();
        $role = Role::create(['name' => 'test']);
        $role->givePermissionTo('permission.index');
        $user->assignRole($role);

        $this->actingAs($user);

        $response = $this->get('/admin/permissions?q=matching');

        $response->assertInertia(function (Assert $page) {
            $page->component('Permission/Index')
                ->has('permissions.data', 1)
                ->where('permissions.total', 1)
                ->where('permissions.data.0.name', 'matching_permission');
        });
    }
}
