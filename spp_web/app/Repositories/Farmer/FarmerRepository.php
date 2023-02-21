<?php

namespace App\Repositories\Farmer;

use App\Models\Village;
use App\Models\District;
use App\Repositories\Village\BaseVillageRepository;
use App\Interfaces\Repository\VillageRepositoryInterface;

class FarmerRepository extends BaseVillageRepository implements VillageRepositoryInterface
{
    protected $indexTableAction = [
        'show' => [
            'text'  =>  'Lihat',
            'type'  =>  'redirect',
            'route' =>  'dashboard.district.village.show',
            'routeParameter'    =>  [
                'district'  =>  'district_id',
                'village'   =>  'id',
            ],
            'color' =>  'primary',
        ],
        'destroy' => [
            'text'  =>  'Hapus',
            'type'  =>  'delete',
            'route' =>  'dashboard.district.village.destroy',
            'routeParameter'    =>  [
                'district'  =>  'district_id',
                'village'   =>  'id',
            ],
            'color' =>  'danger',
        ]
    ];

    public function index()
    {
        return Village::query()
            ->with(
                [
                    'farmers'
                ]
            )
            ->withCount(
                [
                    'farmers'
                ]
            )
            ->get()
            //
        ;
    }

    public function prepareDatatable($datas, $config = null)
    {
        $config = $this->datatableConfig;
        // $config['actions'] = $this->indexTableAction;
        return parent::prepareDatatable($datas, $config);
    }

    public function farmersDatatable($datas)
    {
        if (!is_array($datas)) {
            $datas->toArray();
        }
        dd($datas);
    }
}
