<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $divisions = [
            [
                'name'  =>  'Prasarana dan Saranan Pertanian',
                'nickname'  =>  'PSP',
            ],
            [
                'name'  =>  'Perkebunan',
                'nickname'  =>  'KBN',
            ],
            [
                'name'  =>  'Tanaman Pangan dan Hortikultura',
                'nickname'  =>  'TPH',
            ],
            [
                'name'  =>  'Peternakan',
                'nickname'  =>  'TNK',
            ],
        ];

        foreach ($divisions as $division) {
            Division::create($division);
        }
    }
}
