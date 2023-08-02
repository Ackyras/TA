<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Period;
use App\Repositories\Period\PeriodRepository;

class ArchiveController extends Controller
{
    protected PeriodRepository $repo;

    public function __construct(PeriodRepository $periodRepository)
    {
        $this->repo = $periodRepository;
    }

    public function index()
    {
        $periods = $this->repo->index();
        $periods = $this->repo->prepareDatatable($periods->toArray(), 'archive');
        return view('pages.dashboard.archive.index', compact('periods'));
    }

    public function show(Period $period)
    {
        return view('pages.dashboard.archive.show', compact('period'));
    }
}
