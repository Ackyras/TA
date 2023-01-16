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
    }
}
