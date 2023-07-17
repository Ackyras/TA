<?php

namespace App\Repositories\Request;

use App\Repositories\BaseRepository;

class BaseRequestRepository extends BaseRepository
{
    protected $datatableConfig = [
        'headers'   => [
            'kode'  =>  'code',
            'Judul Kegiatan' =>  'name',
        ],
        'caption'   => 'Table of Request'
    ];
}
