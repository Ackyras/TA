<?php

namespace App\Http\Controllers\Dashboard\Setting\Period;

use App\Models\Period;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Period\StorePeriodRequest;
use App\Repositories\Period\PeriodRepository;

class PeriodController extends Controller
{
    protected PeriodRepository $repo;

    public function __construct(PeriodRepository $periodRepository)
    {
        $this->repo = $periodRepository;
    }

    //
    public function index()
    {
        $periods = $this->repo->index();
        $periods = $this->repo->prepareDatatable($periods->toArray());
        return view('pages.dashboard.period.index', compact('periods'));
    }

    public function store(StorePeriodRequest $request)
    {
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
        dd($validated);
    }
}
