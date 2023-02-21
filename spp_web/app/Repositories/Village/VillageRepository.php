<?php

namespace App\Repositories\Village;

use App\Models\Village;
use App\Repositories\Farmer\FarmerRepository;
use App\Repositories\Village\BaseVillageRepository;

class VillageRepository extends BaseVillageRepository
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

    public $farmerRepository;

    public function __construct(FarmerRepository $farmerRepository)
    {
        $this->farmerRepository = $farmerRepository;
    }

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
        $config['actions'] = $this->indexTableAction;
        return parent::prepareDatatable($datas, $config);
    }

    public function farmersDatatable($datas)
    {
        if (!is_array($datas)) {
            $datas->toArray();
        }
        return $this->farmerRepository->prepareDatatable($datas);
    }
}
