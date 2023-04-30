<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'dashboard.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard.summary_data', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard.kaizen_chart', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard.kaizen_category', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard.new_kaizen_table', 'guard_name' => 'web']);

        Permission::create(['name' => 'user.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'user.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'user.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'user.delete', 'guard_name' => 'web']);

        Permission::create(['name' => 'departement.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'departement.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'departement.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'departement.delete', 'guard_name' => 'web']);

        Permission::create(['name' => 'category.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'category.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'category.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'category.delete', 'guard_name' => 'web']);

        Permission::create(['name' => 'role.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'role.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'role.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'role.delete', 'guard_name' => 'web']);

        Permission::create(['name' => 'permission.index', 'guard_name' => 'web']);

        Permission::create(['name' => 'kaizen.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'kaizen.show', 'guard_name' => 'web']);
        Permission::create(['name' => 'kaizen.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'kaizen.delete', 'guard_name' => 'web']);
        Permission::create(['name' => 'kaizen.pic', 'guard_name' => 'web']);
        Permission::create(['name' => 'kaizen.secretary', 'guard_name' => 'web']);

        Permission::create(['name' => 'app.log', 'guard_name' => 'web']);
    }
}
