<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\Farmer;
use App\Models\Period;
use App\Models\Program;
use Illuminate\Database\Seeder;
use App\Models\RequestAttachment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
        $programs = Program::query()
            ->where('is_parent', false)
            ->get();
        $period = Period::where('is_active', true)->first();
        foreach ($farmers as $farmer) {
            $tempPrograms = $programs->random(rand(1, 3));
            foreach ($tempPrograms as $program) {
                $unit = Unit::inRandomOrder()->first();
                $pivotData = [
                    'volume' => rand(1, 20),
                    'unit_id' => $unit->id,
                    'period_id' => $period->id,
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
