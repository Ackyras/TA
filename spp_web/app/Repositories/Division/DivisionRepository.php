<?php

namespace App\Repositories\Division;

use App\Models\Division;
use App\Repositories\Division\BaseDivisionRepository;

class DivisionRepository extends BaseDivisionRepository
{
    protected $indexTableAction = [
        'show' => [
            'text'  =>  'Detail',
            'type'  =>  'redirect',
            'route' =>  'dashboard.setting.division.show',
            'color' =>  'primary',
        ],
        'destroy' => [
            'text'  =>  'Hapus',
            'type'  =>  'delete',
            'route' =>  'dashboard.setting.division.destroy',
            'color' =>  'danger',
        ],
    ];

    public function index()
    {
        return Division::query()
            ->when(
                auth()->user()->hasRole('kabid'),
                function ($query) {
                    $query->whereHas('users', function ($subQuery) {
                        $subQuery->where('users.id', auth()->id());
                    });
                }
            )
            ->get();
    }

    public function update(array $datas, Division $division)
    {
        if ($division->update($datas)) {
            return true;
        }
        return false;
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
