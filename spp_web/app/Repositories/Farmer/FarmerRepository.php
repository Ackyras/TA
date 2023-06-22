<?php

namespace App\Repositories\Farmer;

use App\Models\Farmer;
use App\Models\Village;
use App\Models\District;
use App\Repositories\Farmer\BaseFarmerRepository;

class FarmerRepository extends BaseFarmerRepository
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
        return Farmer::query()
            ->with(
                [
                    'village'   =>  function ($query) {
                        $query->select(
                            [
                                'id',
                                'name',
                                'district_id'
                            ],
                        );
                    },
                    'village.district'  =>  function ($query) {
                        $query->select(
                            [
                                'id',
                                'name'
                            ]
                        );
                    }
                ]
            )
            ->get(
                [
                    'name',
                    'address',
                    'pic',
                    'village_id'
                ],
            )
            // ->random(1)
            // ->dd()
            //
        ;
    }

    public function prepareDatatable($datas, $config = null)
    {
        $config = $this->datatableConfig;
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
