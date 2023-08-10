<?php

namespace App\Http\Controllers\Dashboard\Setting\Division;

use App\Models\User;
use App\Models\Division;
use App\Http\Controllers\Controller;
use App\Repositories\Division\DivisionRepository;
use App\Http\Requests\Division\StoreDivisionRequest;
use App\Http\Requests\Division\UpdateDivisionRequest;

class DivisionController extends Controller
{
    private DivisionRepository $repo;

    public function __construct(DivisionRepository $userRepository)
    {
        $this->repo = $userRepository;
    }

    public function index()
    {
        $divisions = $this->repo->index();
        if ($divisions->count() == 1 && auth()->user()->hasRole('kabid')) {
            return view('pages.dashboard.division.show')->with(
                [
                    'division'  =>  $divisions->first()
                ]
            );
        }
        $divisionTable = $this->repo->prepareDatatable($divisions->toArray());

        return view('pages.dashboard.division.index', compact('divisionTable'));
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
     * @param  \App\Http\Requests\StoreDivisionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDivisionRequest $request)
    {
        //
        $validated = $request->validated();

        if ($this->repo->store($validated)) {
            return back()->with(
                [
                    'created'   =>  __('message.division.created')
                ]
            );
        }
        return back()->with(
            [
                'failed'   =>  __('message.division.notCreated')
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function show(Division $division)
    {
        //
        return view('pages.dashboard.division.show', compact('division'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function edit(Division $division)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDivisionRequest  $request
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDivisionRequest $request, Division $division)
    {
        //
        if ($this->repo->update($request->validated(), $division)) {
            return back()->with(
                [
                    'updated'   =>  __('message.division.updated')
                ]
            );
        }
        return back()->with(
            [
                'failed'   =>  __('message.division.notUpdated')
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function destroy(Division $division)
    {
        //
        if ($division->delete()) {
            return back()->with(
                [
                    'destroyed'   =>  __('message.division.deleted')
                ]
            );
        }

        return back()->with(
            [
                'failed'    =>  __('message.division.notDeleted')
            ]
        );
    }
}
