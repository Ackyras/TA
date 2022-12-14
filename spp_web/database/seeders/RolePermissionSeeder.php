<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allCruds = [
            'create',
            'read',
            'update',
            'delete',
        ];

        $allPermissions = [
            [
                'users' =>  $allCruds
            ],
            [
                'divisions' =>  $allCruds
            ],
            [
                'periods' =>  $allCruds
            ],
            [
                'supports' =>  $allCruds
            ],
            [
                'districts' =>  $allCruds
            ],
            [
                'villages' =>  $allCruds
            ],
            [
                'farmers' =>  $allCruds
            ],
            [
                'requests' =>  $allCruds
            ],
        ];
        $dev = Role::where('name', 'dev')->first();
        $kadis = Role::where('name', 'kadis')->first();
        $kabid = Role::where('name', 'kabid')->first();
        $koor = Role::where('name', 'koor')->first();
        foreach ($allPermissions as $permissions) {
            foreach ($permissions as $key => $cruds) {
                $parentPermission = Permission::create(
                    [
                        'name'  =>  $key,
                    ]
                );
                $parentPermission->assignRole($dev);
                foreach ($cruds as $crud) {
                    $childPermissions = Permission::create(
                        [
                            'name'  =>  $key . '.' . $crud,
                        ]
                    );
                    $childPermissions->assignRole($dev);
                }
            }
        }
        $kadis->syncPermissions(
            [
                'users',
                'districts',
                'villages',
                'divisions',
                'periods',
                'supports',
                'requests.read',
                'requests.update',
                'farmers',
            ]
        );
        $kabid->syncPermissions(
            [
                'supports',
                'requests.read',
                'requests.update',
                'farmers.read',
            ]
        );
        $koor->syncPermissions(
            [
                'supports.read',
                'requests',
                'villages',
                'farmers',
            ]
        );
    }
}
