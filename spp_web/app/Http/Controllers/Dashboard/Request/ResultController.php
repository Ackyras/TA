<?php

namespace App\Http\Controllers\Dashboard\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request\Result\StoreRequestResultRequest;
use App\Models\Request as ModelsRequest;
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

    public function store(StoreRequestResultRequest $httpRequest, ModelsRequest $request)
    {
        $validated = $httpRequest->validated();
        if ($request->results()->create($validated)) {
            return back()->with(
                [
                    'created'   =>  __('message.requestResult.created')
                ]
            );
        }
        return back()->with(
            [
                'failed'   =>  __('message.requestResult.notCreated')
            ]
        );
    }
}
