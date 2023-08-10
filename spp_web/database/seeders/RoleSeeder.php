<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $roles = [
            // [
            //     'name'          =>  'dev',
            //     'long_name'     =>  'Developer',
            // ],
            [
                'name'          =>  'kadis',
                'long_name'     =>  'Kepala Dinas',
            ],
            [
                'name'          =>  'kabid',
                'long_name'     =>  'Kepala Bidang',
            ],
            [
                'name'          =>  'koor',
                'long_name'     =>  'Koordinator Penyuluh',
            ],
        ];
        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
