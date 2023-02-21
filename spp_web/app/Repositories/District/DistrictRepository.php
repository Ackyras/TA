<?php

namespace App\Repositories\District;

use App\Models\District;
use App\Repositories\Village\VillageRepository;
use App\Repositories\District\BaseDistrictRepository;

class DistrictRepository extends BaseDistrictRepository
{
    protected $indexTableAction = [
        'show' => [
            'text'  =>  'Lihat',
            'type'  =>  'redirect',
            'route' =>  'dashboard.district.show',
            'color' =>  'primary',
        ],
        'destroy' => [
            'text'  =>  'Hapus',
            'type'  =>  'delete',
            'route' =>  'dashboard.district.destroy',
            'color' =>  'danger',
        ]
    ];

    public $villageRepository;

    public function __construct(VillageRepository $villageRepository)
    {
        $this->villageRepository = $villageRepository;
    }

    public function index()
    {
        return District::query()
            ->with(
                [
                    'villages'
                ]
            )
            ->withCount(
                [
                    'villages'
                ]
            )
            ->get()
            //
        ;
    }

    public function prepareDatatable($datas, $config = null)
    {
        $config = $this->datatableConfig;
        $config['actions'] = $this->indexTableAction;
        return parent::prepareDatatable($datas, $config);
    }

    public function villagesDatatable($datas)
    {
        if (!is_array($datas)) {
            $datas->toArray();
        }
        return $this->villageRepository->prepareDatatable($datas);
    }
}
