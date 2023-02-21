<?php

namespace Database\Seeders;

use App\Models\Farmer;
use App\Models\Village;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FarmerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $villages = Village::all();
        foreach ($villages as $village) {
            Farmer::factory(rand(10, 20))->for($village)->create();
        }
    }
}
