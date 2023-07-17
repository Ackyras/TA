<?php

namespace Database\Seeders;

use App\Models\Period;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MultiPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $periods = [
            [
                'name'          =>  'Last 2 year period',
                'start_date'    =>  now()->subYears(2)->startOfYear(),
                'end_date'      =>  now()->subYears(2)->endOfYear(),
                'is_active'     =>  true
            ],
            [
                'name'          =>  'Last 1 year period',
                'start_date'    =>  now()->subYear()->startOfYear(),
                'end_date'      =>  now()->subYear()->endOfYear(),
                'is_active'     =>  true
            ],
            [
                'name'          =>  'Current period',
                'start_date'    =>  now()->startOfYear(),
                'end_date'      =>  now()->endOfYear(),
                'is_active'     =>  true
            ],
        ];

        $this->call(
            [
                RoleSeeder::class,
                RolePermissionSeeder::class,
                UnitSeeder::class,
                DivisionSeeder::class,
                DistrictSeeder::class,
                FarmerSeeder::class,
                UserSeeder::class,
            ],
        );

        foreach ($periods as $key => $period) {
            $tempPeriod = Period::create($period);
            $this->runSeeder();
            if ($key + 1 < sizeof($periods)) {
                $tempPeriod->update(
                    [
                        'is_active' =>  false
                    ]
                );
            }
        }
    }

    public function runSeeder()
    {
        $this->call(
            [
                ProgramSeeder::class,
                RequestSeeder::class,
            ]
        );
    }
}
