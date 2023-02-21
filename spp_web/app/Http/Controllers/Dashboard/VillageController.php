<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Village;
use App\Models\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Village\VillageRepository;

class VillageController extends Controller
{
    protected VillageRepository $repo;

    public function __construct(VillageRepository $villageRepository)
    {
        $this->repo = $villageRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = $this->repo->index();
        dd($data);
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
     * @param  \App\Models\Village  $village
     * @return \Illuminate\Http\Response
     */
    public function show(District $district, Village $village)
    {
        //
        $village->load(
            [
                'farmers',
            ],
        )->loadCount(
            [
                'farmers'
            ]
        );
        $table = $this->repo->farmersDatatable($village->farmers->toArray());
        return view('pages.dashboard.village.show', compact('village'));
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
    public function update(Request $request, Village $village)
    {
        //
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
                    'destroyed'   =>  'Data desa berhasil dihapus'
                ]
            );
        }

        return back()->with(
            [
                'failed'    =>  'Data desa gagal dihapus'
            ]
        );
    }
}
