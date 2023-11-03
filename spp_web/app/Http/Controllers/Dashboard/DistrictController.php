<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\District\StoreDistrictRequest;
use App\Http\Requests\District\UpdateDistrictRequest;
use App\Interfaces\Repository\DistrictRepositoryInterface;
use App\Models\District;
use App\Repositories\District\DistrictRepository;
use Illuminate\Http\Request;

class DistrictController extends Controller
{

    protected DistrictRepository $repo;

    public function __construct(DistrictRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $districts = $this->repo->index();
        if ($districts->count() == 1 && auth()->user()->hasRole('koor')) {
            // $datas = $this->repo->show($districts->first());
            return $this->show($districts->first());
        }
        $districtTable = $this->repo->prepareDatatable($districts->toArray());
        return view('pages.dashboard.district.index', compact('districts', 'districtTable'));
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
    public function store(StoreDistrictRequest $request)
    {
        //
        $validated = $request->validated();
        if ($this->repo->store($validated)) {
            return back()->with(
                [
                    'created'   =>  __('message.district.created')
                ]
            );
        }
        return back()->with(
            [
                'failed'   =>  __('message.district.notCreated')
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function show(District $district)
    {
        //
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
        $table = $this->repo->villagesDatatable($district->villages->toArray());
        // dd($district->villages->toArray());
        return view('pages.dashboard.district.show', compact('district', 'table'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function edit(District $district)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDistrictRequest $request, District $district)
    {
        //
        $validated = $request->validated();
        if ($this->repo->update($district, $validated)) {
            return back()->with(
                [
                    'created'   =>  __('message.district.updated')
                ]
            );
        }
        return back()->with(
            [
                'failed'   =>  __('message.district.notUpdated')
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function destroy(District $district)
    {
        //
        if ($district->delete()) {
            return back()->with(
                [
                    'destroyed'   =>  __('message.district.deleted')
                ]
            );
        }

        return back()->with(
            [
                'failed'    =>  __('message.district.notDeleted')
            ]
        );
    }
}
