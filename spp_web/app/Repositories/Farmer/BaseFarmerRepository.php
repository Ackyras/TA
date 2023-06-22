<?php

namespace App\Repositories\Farmer;

use App\Repositories\BaseRepository;

class BaseFarmerRepository extends BaseRepository
{
    protected $datatableConfig = [
        'headers'   => [
            'Nama'          =>  'name',
            'Alamat'        =>  'address',
            'PIC'           =>  'pic',
        ],
        'caption'   => 'Table of Farmer in District'
    ];
}
