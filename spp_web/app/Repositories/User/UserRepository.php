<?php

namespace App\Repositories\User;

use App\Repositories\User\BaseUserRepository;
use App\Models\User;

class UserRepository extends BaseUserRepository
{
    protected $indexTableAction = [
        'show' => [
            'text'  =>  'Lihat',
            'type'  =>  'redirect',
            'route' =>  'dashboard.setting.user.show',
            'color' =>  'primary',
        ],
        'destroy' => [
            'text'  =>  'Hapus',
            'type'  =>  'delete',
            'route' =>  'dashboard.setting.user.destroy',
            'color' =>  'danger',
        ]
    ];

    public function index()
    {
        // return User::with('divisions')->get();
        return User::all();
    }

    public function show(User $user)
    {
        $user->load('roles.permissions', 'permissions');
        if ($user->can('divisions')) {
            $user->load('divisions');
        }

        // Check if the user has the 'koor' role
        if ($user->can('districts')) {
            $user->load('districts');
        }

        return $user;
    }

    public function store(array $datas)
    {
        $userCreated = false;
        $roleAssigned = false;
        $responsibilityAssigned = false;
        if ($user = User::create(
            [
                'name'  =>  $datas['name'],
                'email'  =>  $datas['email'],
                'password'  =>  bcrypt($datas['password']),
            ]
        )) {
            $userCreated = true;
        }
        if ($user->assignRole($datas['roles'])) {
            $roleAssigned = true;
        }
        if ($datas['roles'] == 2) {
            $user->divisions()->attach($datas['divisions']);
            $responsibilityAssigned = true;
        } elseif ($datas['roles'] == 3) {
            $user->districts()->attach($datas['villages']);
            $responsibilityAssigned = true;
        } elseif ($datas['roles'] == 1) {
            $responsibilityAssigned = true;
        }
        return $userCreated && $roleAssigned && $responsibilityAssigned;
    }

    public function update(array $datas, User $user)
    {
        $userChanged = false;
        $roleChanged = false;;

        if ($user->update($datas)) {
            $userChanged = true;
        }

        if (isset($datas['roles'])) {
            $user->syncRoles($datas['roles']);
            $roleChanged = true;
        }

        if (!isset($datas['divisions'])) {
            // Remove all relationships between the user and divisions
            $user->divisions()->detach();
        } else {
            $user->divisions()->sync($datas['divisions']);
        }

        if (!isset($datas['villages'])) {
            // Remove all relationships between the user and villages
            $user->districts()->detach();
        } else {
            $user->districts()->sync($datas['villages']);
        }

        return $userChanged && $roleChanged;
    }


    public function prepareDatatable($datas, $config = null)
    {
        $config = $this->datatableConfig;
        $config['actions'] = $this->indexTableAction;
        return parent::prepareDatatable($datas, $config);
    }
}
