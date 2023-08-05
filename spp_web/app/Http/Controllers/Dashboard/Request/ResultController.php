<?php

namespace App\Http\Controllers\Dashboard\Request;

use App\Http\Controllers\Controller;
use App\Repositories\Request\RequestRepository;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    //

    protected RequestRepository $repo;

    public function __construct(RequestRepository $repo)
    {
        $this->repo = $repo;
    }
}
