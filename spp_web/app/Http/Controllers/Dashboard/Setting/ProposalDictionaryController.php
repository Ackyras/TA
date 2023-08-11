<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Http\Controllers\Controller;
use App\Models\ProposalDictionary;
use App\Http\Requests\StoreProposalDictionaryRequest;
use App\Http\Requests\UpdateProposalDictionaryRequest;
use App\Models\Division;
use App\Repositories\Program\ProgramRepository;

class ProposalDictionaryController extends Controller
{
    protected ProgramRepository $repo;

    public function __construct(ProgramRepository $repo)
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
        $programs = $this->repo->dictionaryIndex();
        $divisions = Division::all();
        return view('pages.dashboard.proposal-dictionary.index', compact('programs', 'divisions'));
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
     * @param  \App\Http\Requests\StoreProposalDictionaryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProposalDictionaryRequest $request)
    {
        //
        if ($this->repo->dictionaryStore($request->validated())) {
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
     * @param  \App\Models\ProposalDictionary  $proposalDictionary
     * @return \Illuminate\Http\Response
     */
    public function show(ProposalDictionary $proposalDictionary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProposalDictionary  $proposalDictionary
     * @return \Illuminate\Http\Response
     */
    public function edit(ProposalDictionary $proposalDictionary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProposalDictionaryRequest  $request
     * @param  \App\Models\ProposalDictionary  $proposalDictionary
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProposalDictionaryRequest $request, ProposalDictionary $proposalDictionary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProposalDictionary  $proposalDictionary
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProposalDictionary $proposalDictionary)
    {
        //
    }
}
