<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Spatie\Permission\Models\Role;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $user;

    public function setUp(): void
    {
        parent::setUp();

        $permissions = [
            Permission::create(['name' => 'category.index', 'guard_name' => 'web']),
            Permission::create(['name' => 'category.create', 'guard_name' => 'web']),
            Permission::create(['name' => 'category.edit', 'guard_name' => 'web']),
            Permission::create(['name' => 'category.delete', 'guard_name' => 'web']),
        ];

        $role = Role::create(['name' => 'test']);
        $role->givePermissionTo($permissions);

        $this->user = User::factory()->create();
        $this->user->assignRole($role);
    }

    /** @test */
    public function user_can_view_page_index()
    {
        for ($i = 0; $i < 10; $i++) {
            $name = $this->faker->name;
            if (Category::where('name', $name)->get()->count() > 0) {
                $i--;
                continue;
            }
            Category::create(['name' => $name]);
        }

        $this->actingAs($this->user);
        $response = $this->get(route('categories.index'));
        $response->assertStatus(200);
        $response->assertInertia(
            fn (AssertableInertia $page) => $page
                ->component('Category/Index')
                ->has('categories')
                ->has('categories.data', 5)
                ->where('categories.total', 10)
        );
    }

    /** @test */
    public function user_cant_view_page_index()
    {
        $response = $this->get(route('categories.index'));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('categories.index'));
        $response->assertStatus(403);
        $response->assertForbidden();
    }

    /** @test */
    public function user_can_view_page_create()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('categories.create'));
        $response->assertStatus(200);
        $response->assertInertia(
            fn (AssertableInertia $page) => $page
                ->component('Category/Create')
        );
    }

    /** @test */
    public function user_cant_view_page_create()
    {
        $response = $this->get(route('categories.create'));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('categories.create'));
        $response->assertStatus(403);
        $response->assertForbidden();
    }

    /** @test */
    public function user_can_create_category()
    {
        $this->actingAs($this->user);
        $response = $this->post(route('categories.store'), [
            'name' => $this->faker->name,
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseCount('categories', 1);
    }

    /** @test */
    public function user_cant_create_category()
    {
        $response = $this->post(route('categories.store'), [
            'name' => $this->faker->name,
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('categories.store'), [
            'name' => $this->faker->name,
        ]);
        $response->assertStatus(403);
        $response->assertForbidden();

        $response = $this->actingAs($this->user)->post(route('categories.store'), [
            'name' => '',
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors('name');

        $this->assertDatabaseCount('categories', 0);
    }

    /** @test */
    public function user_can_view_page_edit()
    {
        $category = Category::create(['name' => $this->faker()->name()]);

        $this->actingAs($this->user);
        $response = $this->get(route('categories.edit', $category->id));
        $response->assertStatus(200);
        $response->assertInertia(
            fn (AssertableInertia $page) => $page
                ->component('Category/Edit')
                ->has('category')
                ->where('category.id', $category->id)
        );
    }

    /** @test */
    public function user_cant_view_page_edit()
    {
        $category = Category::create(['name' => $this->faker()->name()]);

        $response = $this->get(route('categories.edit', $category->id));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('categories.edit', $category->id));
        $response->assertStatus(403);
        $response->assertForbidden();

        $response = $this->actingAs($this->user)->get(route('categories.edit', 0));
        $response->assertStatus(404);
        $response->assertNotFound();
    }

    /** @test */
    public function user_can_update_category()
    {
        $category = Category::create(['name' => $this->faker()->name()]);

        $this->actingAs($this->user);
        $response = $this->put(route('categories.update', $category->id), [
            'name' => $this->faker->name,
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseCount('categories', 1);
    }

    /** @test */
    public function user_cant_update_category()
    {
        $category = Category::create(['name' => $this->faker()->name()]);

        $response = $this->put(route('categories.update', $category->id), [
            'name' => $this->faker->name,
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        $user = User::factory()->create();
        $response = $this->actingAs($user)->put(route('categories.update', $category->id), [
            'name' => $this->faker->name,
        ]);
        $response->assertStatus(403);
        $response->assertForbidden();

        $response = $this->actingAs($this->user)->put(route('categories.update', $category->id), [
            'name' => '',
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors('name');

        $response = $this->actingAs($this->user)->put(route('categories.update', 0), [
            'name' => $this->faker->name,
        ]);
        $response->assertStatus(404);
        $response->assertNotFound();
    }

    /** @test */
    public function user_can_delete_category()
    {
        $category = Category::create(['name' => $this->faker()->name()]);

        $this->actingAs($this->user);
        $response = $this->delete(route('categories.destroy', $category->id));
        $response->assertStatus(302);
        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseCount('categories', 0);
    }

    /** @test */
    public function user_cant_delete_category()
    {
        $category = Category::create(['name' => $this->faker()->name()]);

        $response = $this->delete(route('categories.destroy', $category->id));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        $user = User::factory()->create();
        $response = $this->actingAs($user)->delete(route('categories.destroy', $category->id));
        $response->assertStatus(403);
        $response->assertForbidden();

        $response = $this->actingAs($this->user)->delete(route('categories.destroy', 0));
        $response->assertStatus(404);
        $response->assertNotFound();
    }
}
