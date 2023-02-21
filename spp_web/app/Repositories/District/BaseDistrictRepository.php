<?php

namespace App\Repositories\District;

use App\Repositories\BaseRepository;

class BaseDistrictRepository extends BaseRepository
{
    protected $datatableConfig = [
        'headers'   => [
            'Nama'          =>  'name',
            'Jumlah Desa'   =>  'villages_count',
        ],
        'caption'   => 'Table of User'
    ];
}
