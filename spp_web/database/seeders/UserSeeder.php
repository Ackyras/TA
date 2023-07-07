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
        $dev = User::create(
            [
                'name'          =>  'dev',
                'email'         =>  'dev@dev',
                'password'      =>  bcrypt('password'),
            ]
        );
        $dev->assignRole('dev');
        $kadis = User::create(
            [
                'name'          =>  'kadis',
                'email'         =>  'kadis@kadis',
                'password'      =>  bcrypt('password'),
            ]
        );
        $kadis->assignRole('kadis');
        $divisions = Division::all();
        foreach ($divisions as $key => $division) {
            $kabid  =   User::create(
                [
                    'name'      =>  'Kabid ' . str()->lower($division->name),
                    'email'     =>  'kabid' . $key + 1 . '@kabid',
                    'password'      =>  bcrypt('password'),
                ],
            );
            $kabid->assignRole('kabid');
            $kabid->divisions()->attach($division);
        }
        $villages = Village::all();
        foreach ($villages as $key => $village) {
            $koor = User::create(
                [
                    'name'      =>  'Koor ' . str()->lower($village->name),
                    'email'     =>  'koor' . $key + 1 . '@koor',
                    'password'  =>  bcrypt('password'),
                ]
            );
            $koor->assignRole('koor');
            $kabid->villages()->attach($village);
        };
    }
}
