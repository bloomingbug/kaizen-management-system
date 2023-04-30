<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $permissions = [
            Permission::create(['name' => 'dashboard.index', 'guard_name' => 'web']),
            Permission::create(['name' => 'dashboard.summary_data', 'guard_name' => 'web']),
            Permission::create(['name' => 'dashboard.kaizen_chart', 'guard_name' => 'web']),
            Permission::create(['name' => 'dashboard.kaizen_category', 'guard_name' => 'web']),
            Permission::create(['name' => 'dashboard.new_kaizen_table', 'guard_name' => 'web']),
        ];

        $role = Role::create(['name' => 'test']);
        $role->givePermissionTo($permissions);

        $this->user->assignRole($role);
    }

    /** @test */
    public function user_can_view_page_index_with_all_data_and_chart()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertInertia(
            fn (AssertableInertia $page) => $page
                ->component('Dashboard/Index')
                ->has('sumKaizenApproved')
                ->has('sumKaizenRejected')
                ->has('sumKaizenPending')
                ->has('sumKaizenNewSecretary')
                ->has('sumKaizenNewPic')
                ->has('sumKaizenThisMonth')
                ->has('sumKaizenToday')
                ->has('sumKaizen')
                ->has('kaizensNew')
                ->has('categoryDonut')
                ->has('countDonut')
                ->has('dateLine')
                ->has('countLine')
        );
    }

    /** @test */
    public function user_cant_view_page_index()
    {
        $response = $this->get(route('dashboard'));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('dashboard'));
        $response->assertStatus(403);
    }
}
