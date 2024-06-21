<?php

namespace Database\Seeders;

use App\Models\Farmer;
use App\Models\Period;
use App\Models\ProposalDictionary;
use App\Models\RequestAttachment;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class RequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $farmers = Farmer::all();
        $programs = ProposalDictionary::all();
        $period = Period::where('is_active', true)->first();
        foreach ($farmers as $farmer) {
            $tempPrograms = $programs->random(rand(1, 3));
            foreach ($tempPrograms as $program) {
                $unit = Unit::inRandomOrder()->first();
                $pivotData = [
                    'volume' => rand(1, 20),
                    'unit_id' => $unit->id,
                    // 'period_id' => $period->id,
                ];

                $farmer->programs()->attach($program, $pivotData);
            }
            $farmer->load('programs');
            $requests = $farmer->programs;
            foreach ($requests as $request) {
                RequestAttachment::factory(rand(1, 3))->for($request->pivot, 'request')->create();
            }
        }
    }
}
