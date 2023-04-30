<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Safety',

        ]);
        Category::create([
            'name' => 'Quality',
        ]);
        Category::create([
            'name' => 'Productivity',
        ]);
        Category::create([
            'name' => 'Delivery',
        ]);
        Category::create([
            'name' => 'Cost Down',
        ]);
        Category::create([
            'name' => 'Others',
        ]);
    }
}
