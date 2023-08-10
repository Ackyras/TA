<?php

namespace Database\Seeders;

use App\Models\Period;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $oldPeriods = Period::where('is_active', true)->get();
        foreach ($oldPeriods as $period) {
            $period->update('is_active', false);
        }
        $newPeriod = Period::create(
            [
                'name'          =>  'Manual Period',
                'start_date'    =>  now()->startOfYear(),
                'end_date'      =>  now()->endOfYear(),
                'is_active'     =>  true
            ]
        );
        
    }
}
