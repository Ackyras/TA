<?php

namespace App\Http\Controllers\Dashboard\Request;

use App\Http\Controllers\Controller;
use App\Repositories\Request\DivisionRequestRepository;
use Illuminate\Http\Request;

class DivisionRequestController extends Controller
{
    protected $repo;

    public function __construct(DivisionRequestRepository $divisionRequestRepository)
    {
        $this->repo = $divisionRequestRepository;
    }
    //
    public function index()
    {
        $datas = $this->repo->index();
        return view('pages.dashboard.request.division.index', compact('datas'));
    }
}
