<?php

namespace App\Repositories\Division;

use App\Repositories\BaseRepository;

class BaseDivisionRepository extends BaseRepository
{
    protected $datatableConfig = [
        'headers'   => [
            'nama'  =>  'name',
            'kode' =>  'nickname',
        ],
        'caption'   => 'Table of Division'
    ];
}
