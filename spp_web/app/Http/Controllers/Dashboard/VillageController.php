<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Village;
use App\Models\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Village\VillageRepository;
use App\Repositories\District\DistrictRepository;
use App\Http\Requests\Village\StoreVillageRequest;
use App\Http\Requests\Village\UpdateVillageRequest;

class VillageController extends Controller
{
    protected VillageRepository $repo;
    protected DistrictRepository $districtRepo;

    public function __construct(VillageRepository $villageRepository, DistrictRepository $districtRepository)
    {
        $this->repo = $villageRepository;
        $this->districtRepo = $districtRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $villages = $this->repo->index();
        if ($villages->count() == 1 && auth()->user()->hasRole('koor')) {
            $datas = $this->repo->show($villages->first());
            return view('pages.dashboard.village.show')->with(
                [
                    'village'   =>  $datas['village'],
                    'table'     =>  $datas['table']
                ],
            );
        }
        $villageTable = $this->repo->prepareDatatable($villages->toArray());
        // dd($villageTable);
        $districts = $this->districtRepo->index();
        return view('pages.dashboard.village.index', compact('villages', 'villageTable', 'districts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVillageRequest $request)
    {
        //
        $validated = $request->validated();
        // dd($validated);
        if ($this->repo->store($validated)) {
            return back()->with(
                [
                    'created'   =>  __('message.village.created')
                ]
            );
        }
        return back()->with(
            [
                'failed'   =>  __('message.village.notCreated')
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Village  $village
     * @return \Illuminate\Http\Response
     */
    public function show(District $district, Village $village)
    {
        //
        $datas = $this->repo->show($village);
        return view(
            'pages.dashboard.village.show',
        )->with(
            [
                'village'  =>  $datas['village'],
                'table'    =>  $datas['table']
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Village  $village
     * @return \Illuminate\Http\Response
     */
    public function edit(Village $village)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Village  $village
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVillageRequest $request, Village $village)
    {
        //
        $validated = $request->validated();
        if ($this->repo->update($village, $validated)) {
            return back()->with(
                [
                    'created'   =>  __('message.village.updated')
                ]
            );
        }
        return back()->with(
            [
                'failed'   =>  __('message.village.notUpdated')
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Village  $village
     * @return \Illuminate\Http\Response
     */
    public function destroy(District $district, Village $village)
    {
        //
        if ($village->delete()) {
            return back()->with(
                [
                    'destroyed'   =>  __('message.village.deleted')
                ]
            );
        }

        return back()->with(
            [
                'failed'    =>  __('message.village.notDeleted')
            ]
        );
    }
}
