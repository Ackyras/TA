<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
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
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, District $district)
    {
        //
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
    }
}
