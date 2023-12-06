<?php

namespace App\Http\Controllers\Dashboard\Request;

use Illuminate\Http\Request;
use App\Models\RequestResult;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Request as ModelsRequest;
use App\Repositories\Request\RequestRepository;
use App\Http\Requests\Request\Result\StoreRequestResultRequest;
use App\Models\RequestResultAttachment;

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
        $resultCreated = $attachmentsCreated = false;
        $validated = $httpRequest->validated();
        $result = $request->results()->create(
            [
                'request_id'    =>  $request->id,
                'unit_id'       =>  $request->unit_id,
                'volume'        =>  $validated['volume']
            ]
        );
        if ($result) {
            $resultCreated = true;
        }
        if (!$validated['attachments']) {
            $attachmentsCreated = true;
        } else {

            foreach ($validated['attachments'] as $attachment) {
                $this->storeAttachment($result, $attachment);
            }
            $attachmentsCreated = true;
        }
        if ($resultCreated && $attachmentsCreated) {
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
        if ($result->delete()) {
            return back()->with(
                [
                    'destroyed'   =>  __('message.requestResult.deleted')
                ]
            );
        }
        return back()->with(
            [
                'failed'   =>  __('message.requestResult.notDeleted')
            ]
        );
    }

    public function storeAttachment(RequestResult $request, $attachmentData)
    {
        $file = $attachmentData['file'];
        $fileName = $file->hashName();

        $storeFile = Storage::disk('local')->putFileAs(
            'request/result/attachment',
            $file,
            $fileName
        );

        // Create the attachment record with name and URL
        return RequestResultAttachment::create([
            'name' => $attachmentData['name'],
            'url' => $storeFile,
            'request_result_id' => $request->id,
        ]);
    }
}
