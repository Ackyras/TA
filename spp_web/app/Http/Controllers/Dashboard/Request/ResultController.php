<?php

namespace App\Http\Controllers\Dashboard\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request\Result\StoreRequestResultRequest;
use App\Models\Request as ModelsRequest;
use App\Models\RequestResult;
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
        // dd($request);
        if ($result = $request->results()->create(
            [
                'request_id'    =>  $request->id,
                'unit_id'       =>  $request->unit_id,
                'volume'        =>  $validated['volume']
            ]
        )) {

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

    public function destroy(ModelsRequest $request, RequestResult $result)
    {
        // dd($result);
        if ($result->delete()) {
            return back()->with(
                [
                    'failed'   =>  __('message.requestResult.deleted')
                ]
            );
        }
        return back()->with(
            [
                'failed'   =>  __('message.requestResult.notDeleted')
            ]
        );
    }
}
