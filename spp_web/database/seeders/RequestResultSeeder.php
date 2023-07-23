<?php

namespace Database\Seeders;

use App\Models\Request;
use App\Models\RequestResultAttachment;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RequestResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $requests = Request::inRandomOrder()->limit(rand(Request::count() / 5, Request::count() / 3))->get();
        foreach ($requests as $request) {
            $request->update(
                [
                    'status'    =>  'pending'
                ]
            );
            if (rand(0, 1)) {
                $request->update(
                    [
                        'status'    =>  'on progress',
                    ]
                );
                $result = $request->result()->create(
                    [
                        'volume'    =>  $request->volume - rand(0, $request->volume),
                        'unit_id'   =>  $request->unit_id,
                    ]
                );
                if (rand(0, 1)) {
                    $request->update(
                        [
                            'status'    =>  'done',
                        ],
                    );
                    RequestResultAttachment::factory(rand(0, 2))->for($result, 'requestResult')->create();
                }
            } else {
                $request->update(
                    [
                        'status'    =>  'declined'
                    ]
                );
            }
        }
    }
}
