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

    public function prepareDatatable($datas, $config = null)
    {
        $config = $this->datatableConfig;
        $config['actions'] = $this->indexTableAction;
        return parent::prepareDatatable($datas, $config);
    }
}
