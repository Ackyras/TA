<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Village;
use App\Models\Division;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $domain = 'sppbt.toba.gov.id';
        // $dev = User::create(
        //     [
        //         'name'          =>  'dev',
        //         'email'         =>  'dev@' . $domain,
        //         'password'      =>  bcrypt('password'),
        //     ]
        // );
        // $dev->assignRole('dev', 'kadis');
        $kadis = User::create(
            [
                'name'          =>  'kadis',
                'email'         =>  'kadis@' . $domain,
                'password'      =>  bcrypt('password'),
            ]
        );
        $kadis->assignRole('kadis');
        $divisions = Division::all();
        foreach ($divisions as $key => $division) {
            $kabid  =   User::create(
                [
                    'name'      =>  'Kabid ' . str()->title($division->name),
                    'email'     =>  'kabid.' . str()->lower($division->nickname) . '@' . $domain,
                    'password'      =>  bcrypt('password'),
                ],
            );
            $kabid->assignRole('kabid');
            $kabid->divisions()->attach($division);
        }
        $villages = Village::all();
        foreach ($villages as $key => $village) {
            $koor = User::factory()->create();
            $koor->assignRole('koor');
            $koor->villages()->attach($village);
        };
    }
}
