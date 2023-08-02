<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            [
                PeriodSeeder::class,
                RoleSeeder::class,
                RolePermissionSeeder::class,
                UnitSeeder::class,
                DivisionSeeder::class,
                DistrictSeeder::class,
                FarmerSeeder::class,
                UserSeeder::class,
                ProgramSeeder::class,
                RequestSeeder::class,
                RequestResultSeeder::class,
            ]
        );
    }
}
