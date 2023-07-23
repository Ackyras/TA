<?php

namespace App\Repositories\Period;

use App\Repositories\BaseRepository;

class BasePeriodRepository extends BaseRepository
{
    protected $datatableConfig = [
        'headers'   => [
            'nama'              =>  'name',
            'tanggal mulai'     =>  'start_date',
            'tanggal selesai'   =>  'end_date',
            'status'            =>  'is_active',
            // 'bidang'    =>  'divisions'
        ],
        'caption'   => 'Table of Period'
    ];
}
