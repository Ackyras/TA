<?php

namespace App\Repositories\User;

use App\Repositories\BaseRepository;

class BaseUserRepository extends BaseRepository
{
    protected $datatableConfig = [
        'headers'   => [
            'nama'      =>  'name',
            'email'     =>  'email',
            // 'bidang'    =>  'divisions'
        ],
        'caption'   => 'Table of User'
    ];
}
