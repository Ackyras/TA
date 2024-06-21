<?php

namespace Database\Seeders;

use App\Models\Farmer;
use App\Models\Village;
use Illuminate\Database\Seeder;

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
            Farmer::factory(rand(1, 10))->for($village)->create();
        }
    }
}
