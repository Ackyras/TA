<?php

namespace App\Repositories\Program;

use App\Repositories\BaseRepository;

class BaseProgramRepository extends BaseRepository
{
    protected $datatableConfig = [
        'headers'   => [
            'kode'  =>  'code',
            'Judul Kegiatan' =>  'name',
        ],
        'caption'   => 'Table of Program'
    ];
}
