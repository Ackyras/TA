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
            ->when(
                auth()->user()->hasRole('koor'),
                function ($query) {
                    $query->whereHas('users', function ($query) {
                        $query->where('users.id', auth()->user()->id);
                    });
                }
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

    public function show(Village $village)
    {
        $datas['village'] = $village->load(
            [
                'farmers',
            ],
        )->loadCount(
            [
                'farmers'
            ]
        );
        $datas['table'] = $this->farmersDatatable($village->farmers->toArray());
        return $datas;
    }

    public function store(array $datas)
    {
        return Village::create($datas);
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
