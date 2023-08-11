<?php

namespace App\Http\Controllers\Dashboard\Setting\Program;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Http\Requests\Program\StoreProgramRequest;
use App\Http\Requests\Program\UpdateProgramRequest;
use App\Repositories\Program\ProgramRepository;

class ProgramController extends Controller
{
    private ProgramRepository $repo;

    public function __construct(ProgramRepository $programRepository)
    {
        $this->repo = $programRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $programs = $this->repo->index();
        // dd($programs[0]);
        return view('pages.dashboard.program.index', compact('programs'));
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
     * @param  \App\Http\Requests\StoreProgramRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProgramRequest $request)
    {
        //
        // dd($request->validated());
        if ($this->repo->store($request->validated())) {
            return back()->with(
                [
                    'created'   =>  __('message.program.created')
                ]
            );
        }
        return back()->with(
            [
                'failed'   =>  __('message.program.notCreated')
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function show(Program $program)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function edit(Program $program)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProgramRequest  $request
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProgramRequest $request, Program $program)
    {
        //
        if ($this->repo->update($program, $request->validated())) {
            return back()->with(
                [
                    'updated'   =>  __('message.program.updated')
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
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function destroy(Program $program)
    {
        //
        if ($program->delete()) {
            return back()->with(
                [
                    'destroyed'   =>  __('message.program.deleted')
                ]
            );
        }

        return back()->with(
            [
                'failed'    =>  __('message.program.notDeleted')
            ]
        );
    }
}
