<?php

namespace App\Repositories\Division;

use App\Models\Division;
use App\Repositories\Division\BaseDivisionRepository;

class DivisionRepository extends BaseDivisionRepository
{
    protected $indexTableAction = [
        'destroy' => [
            'text'  =>  'Hapus',
            'type'  =>  'delete',
            'route' =>  'dashboard.setting.division.destroy',
            'color' =>  'danger',
        ],
    ];

    public function index()
    {
        return Division::all();
    }

    public function store(array $data)
    {
        return Division::create($data);
    }

    public function prepareDatatable($datas, $config = null)
    {
        $config = $this->datatableConfig;
        $config['actions'] = $this->indexTableAction;
        return parent::prepareDatatable($datas, $config);
    }
}
