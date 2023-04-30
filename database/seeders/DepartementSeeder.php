<?php

namespace Database\Seeders;

use App\Models\Departement;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Departement::create([
            'name' => 'IT',
        ]);
        Departement::create([
            'name' => 'HRD',
        ]);
        Departement::create([
            'name' => 'Finance',
        ]);
        Departement::create([
            'name' => 'Marketing',
        ]);
        Departement::create([
            'name' => 'Production',
        ]);
        Departement::create([
            'name' => 'Warehouse',
        ]);
        Departement::create([
            'name' => 'Purchasing',
        ]);
    }
}
