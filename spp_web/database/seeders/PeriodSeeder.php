<?php

namespace Database\Seeders;

use App\Models\Period;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeriodSeeder extends Seeder
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
                'name'          =>  'Dev period',
                'start_date'    =>  now()->startOfYear(),
                'end_date'      =>  now()->endOfYear(),
                'is_active'     =>  true
            ]
        ];

        foreach ($periods as $period) {
            Period::create($period);
        }
    }
}
