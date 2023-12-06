<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Farmer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Farmer\StoreFarmerRequest;
use App\Models\Village;
use App\Repositories\Farmer\FarmerRepository;

class FarmerController extends Controller
{
    protected FarmerRepository $repo;

    public function __construct(FarmerRepository $farmerRepository)
    {
        $this->repo = $farmerRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $farmers = $this->repo->index($request);
        $villages = Village::query()
            ->when(
                auth()->user()->hasRole(3),
                function ($query) {
                    $query->whereHas('district', function ($query) {
                        $query->whereHas('users', function ($query) {
                            $query->where('user_id', auth()->user()->id);
                        });
                    });
                }
            )->get();
        return view('pages.dashboard.farmer.index', compact('farmers', 'villages'));
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
    public function store(StoreFarmerRequest $request)
    {
        //
        $validated = $request->validated();
        if ($this->repo->store($validated)) {
            return back()->with(
                [
                    'created'   =>  __('message.farmer.updated')
                ]
            );
        }
        return back()->with(
            [
                'failed'   =>  __('message.farmer.notUpdated')
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Farmer  $farmer
     * @return \Illuminate\Http\Response
     */
    public function show(Farmer $farmer)
    {
        //
        $datas = $this->repo->show($farmer);
        return view('pages.dashboard.farmer.show', compact('datas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Farmer  $farmer
     * @return \Illuminate\Http\Response
     */
    public function edit(Farmer $farmer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Farmer  $farmer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Farmer $farmer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Farmer  $farmer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Farmer $farmer)
    {
        //
        if ($farmer->delete()) {
            return back()->with(
                [
                    'destroyed'   =>  __('message.farmer.deleted')
                ]
            );
        }

        return back()->with(
            [
                'failed'    =>  __('message.farmer.notDeleted')
            ]
        );
    }
}
