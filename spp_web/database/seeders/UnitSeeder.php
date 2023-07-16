<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units = [
            // Distance Units
            ['name' => 'Kilometer', 'code' => 'KM', 'type' => 'distance'],
            ['name' => 'Meter', 'code' => 'M', 'type' => 'distance'],
            ['name' => 'Mil', 'code' => 'MI', 'type' => 'distance'],
            ['name' => 'Yard', 'code' => 'YD', 'type' => 'distance'],
            ['name' => 'Kaki', 'code' => 'FT', 'type' => 'distance'],

            // Weight Units
            ['name' => 'Kilogram', 'code' => 'KG', 'type' => 'weight'],
            ['name' => 'Gram', 'code' => 'G', 'type' => 'weight'],
            ['name' => 'Pound', 'code' => 'LB', 'type' => 'weight'],
            ['name' => 'Ons', 'code' => 'ONS', 'type' => 'weight'],
            ['name' => 'Ton', 'code' => 'TON', 'type' => 'weight'],

            // Quantity Units
            ['name' => 'Buah', 'code' => 'PCS', 'type' => 'quantity'],
            ['name' => 'Set', 'code' => 'SET', 'type' => 'quantity'],
            ['name' => 'Kotak', 'code' => 'BOX', 'type' => 'quantity'],
            ['name' => 'Kantong', 'code' => 'KTN', 'type' => 'quantity'],
            ['name' => 'Bundel', 'code' => 'BDL', 'type' => 'quantity'],

            // Additional Units
            ['name' => 'Lusin', 'code' => 'LUSIN', 'type' => 'dozens'],
            ['name' => 'Rim', 'code' => 'RIM', 'type' => 'rim'],
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
}
