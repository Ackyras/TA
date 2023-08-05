<?php

namespace App\Repositories\Farmer;

use App\Models\Farmer;
use App\Models\Village;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Repositories\Farmer\BaseFarmerRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class FarmerRepository extends BaseFarmerRepository
{
    protected $indexTableAction = [
        'show' => [
            'text'  =>  'Lihat',
            'type'  =>  'redirect',
            'route' =>  'dashboard.farmer.show',
            'color' =>  'primary',
        ],
        'destroy' => [
            'text'  =>  'Hapus',
            'type'  =>  'delete',
            'route' =>  'dashboard.farmer.destroy',
            'color' =>  'danger',
        ]
    ];

    protected $allowedFilters = [
        'name',
        'pic',
    ];

    public function index(Request $request)
    {
        $query = Farmer::query()
            ->when(
                auth()->user()->hasRole('koor')
            )
            ->select(['name', 'address', 'pic', 'village_id', 'id'])
            ->with([
                'village' => function ($query) {
                    $query->select(['id', 'name', 'district_id']);
                },
                'village.district' => function ($query) {
                    $query->select(['id', 'name']);
                }
            ]);

        $farmers = $this->filter($query, $request, false, true, 10);
        return $farmers->withQueryString();
    }

    public function show(Farmer $farmer)
    {
        $datas = [];
        $datas['farmer'] = $farmer->load(
            [
                'requests' => function ($query) {
                    $query->with(
                        [
                            'program'   =>  function ($query) {
                                $query->withoutGlobalScope('current_period');
                            },
                            'unit',
                            'attachments'
                        ]
                    );
                },
                'village' => function ($query) {
                    $query->select(['id', 'name', 'district_id']);
                },
                'village.district' => function ($query) {
                    $query->select(['id', 'name']);
                }
            ]
        )->loadCount([
            'requests'
        ]);
        return $datas;
    }

    public function store(array $data)
    {
        return Farmer::create($data);
    }

    public function update(Farmer $farmer, array $data)
    {
        $farmer->update($data);
        return $farmer->wasChanged();
    }

    public function prepareDatatable($datas, $withActions = false)
    {
        $config = $this->datatableConfig;
        $config['actions'] = $this->indexTableAction;
        return parent::prepareDatatable($datas, $config);
    }
}
