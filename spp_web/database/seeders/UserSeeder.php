<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
        for ($i = 0; $i < 9; $i++) {
            $kabid = User::create(
                [
                    'name'          =>  'kabid' . $i,
                    'email'         =>  'kabid' . $i . '@kabid',
                    'password'      =>  bcrypt('password'),
                ]
            );
            $kabid->assignRole('kabid');
        }
        for ($i = 0; $i < rand(15, 50); $i++) {
            $koor = User::create(
                [
                    'name'          =>  'koor' . $i,
                    'email'         =>  'koor' . $i . '@koor',
                    'password'      =>  bcrypt('password'),
                ]
            );
            $koor->assignRole('koor');
        }
    }
}
