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
            ->when(
                auth()->user()->hasRole('koor'),
                function ($query) {
                    $query->whereHas('users', function ($query) {
                        $query->where('users.id', auth()->user()->id);
                    });
                }
            )
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

    public function store(array $data)
    {
        return District::create($data);
    }

    public function show(District $district)
    {
        $district->load(
            [
                'villages'  =>  function ($query) {
                    $query->withCount('farmers');
                }
            ]
        )->loadCount(
            [
                'villages',
                'farmers'
            ]
        );
        $datas['district'] = $district;
        $datas['table'] = $this->villagesDatatable($district->villages->toArray());
        return District::create($datas);
    }

    public function update(District $district, array $data)
    {
        $district->update($data);
        return $district->wasChanged();
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
