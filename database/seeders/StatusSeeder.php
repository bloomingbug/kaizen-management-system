<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create([
            'name' => 'Terkirim',
            'description' => 'Kaizen Telah Terkirim, Menunggu Diperiksa'
        ]);
        Status::create([
            'name' => 'Pending',
            'description' => 'Dalam Study/Pertimbangan'
        ]);
        Status::create([
            'name' => 'Approved',
            'description' => 'Bisa Dijalankan'
        ]);
        Status::create([
            'name' => 'Rejected',
            'description' => 'Tidak Bisa Dijalankan'
        ]);
    }
}
