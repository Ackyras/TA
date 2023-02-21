<?php

namespace App\Repositories\Village;

use App\Repositories\BaseRepository;

class BaseVillageRepository extends BaseRepository
{
    protected $datatableConfig = [
        'headers'   => [
            'Nama'          =>  'name',
            'Jumlah Kelompok Tani'   =>  'farmers_count',
        ],
        'caption'   => 'Table of Villages in District'
    ];
}
