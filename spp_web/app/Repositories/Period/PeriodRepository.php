<?php

namespace App\Repositories\Period;

use App\Repositories\Period\BasePeriodRepository;
use App\Models\Period;

class PeriodRepository extends BasePeriodRepository
{
    protected $indexTableAction = [
        'destroy' => [
            'text'  =>  'Hapus',
            'type'  =>  'delete',
            'route' =>  'dashboard.setting.period.destroy',
            'color' =>  'danger',
        ]
    ];

    protected $archiveTableAction = [
        'show' => [
            'text'  =>  'Lihat',
            'type'  =>  'redirect',
            'route' =>  'dashboard.archive.show',
            'color' =>  'primary',
        ]
    ];

    public function index()
    {
        $periods = Period::query()
            ->withCount(
                [
                    'programs',
                    'requests',
                ]
            )
            ->get()
            //
        ;
        return Period::all();
    }

    public function store(array $datas)
    {
        $oldPeriod = getCurrentPeriod();
        $period = Period::create($datas);
        if ($datas['deactivate_active_period']) {
            $oldPeriod->update([
                'is_active' =>  false,
            ]);
            $period->update(
                [
                    'is_active' =>  true,
                ]
            );
            return true;
        }
        return false;
    }

    public function prepareDatatable($datas, $type = 'index')
    {
        foreach ($this->datatableConfig as $key => $config) {
            $configs[$key] = $config;
        }
        if ($type == 'index') {
            $configs['actions'] = $this->indexTableAction;
        } elseif ($type == 'archive') {
            $configs['actions'] = $this->archiveTableAction;
        }
        foreach ($datas as $key => $data) {
            if ($datas[$key]['is_active'] == true) {
                $datas[$key]['is_active'] = 'Active';
            } else {
                $datas[$key]['is_active'] = 'Inactive';
            }
        }
        return parent::prepareDatatable($datas, $configs);
    }
}
