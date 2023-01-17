<?php

namespace App\Repositories;

use App\Interfaces\BaseInterface;
use App\Traits\Datatables\V1\DatatableTrait;

class BaseRepository
{
    use DatatableTrait;

    protected $datatableConfig;

    public function prepareDatatable($datas, $config = null)
    {
        if (!$config) {
            $config = $this->datatableConfig;
        }
        return $this->prepare($config, $datas);
    }
}
