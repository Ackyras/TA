<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\Farmer;
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
        foreach ($farmers as $farmer) {
            $tempPrograms = $programs->random(rand(1, 3));
            foreach ($tempPrograms as $program) {
                $unit = Unit::inRandomOrder()->first();
                $pivotData = [
                    'volume' => rand(1, 20),
                    'unit_id' => $unit->id,
                    'period_id' => 1,
                ];

                $farmer->requests()->attach($program, $pivotData);
            }
            $farmer->load('requests');
            $requests = $farmer->requests;
            foreach ($requests as $request) {
                RequestAttachment::factory(rand(1, 3))->for($request->pivot)->create();
            }
        }
    }
}
