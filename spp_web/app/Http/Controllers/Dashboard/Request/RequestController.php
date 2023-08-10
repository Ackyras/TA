<?php

namespace App\Http\Controllers\Dashboard\Request;

use Illuminate\Http\Request;
use App\Models\RequestAttachment;
use App\Http\Controllers\Controller;
use App\Repositories\Request\RequestRepository;
use App\Http\Requests\Request\StoreRequestRequest;
use App\Http\Requests\Request\UpdateRequestRequest;
use App\Models\Request as ModelsRequest;

class RequestController extends Controller
{
    //
    protected $repo;

    public function __construct(RequestRepository $requestRepository)
    {
        $this->repo = $requestRepository;
    }

    public function index(Request $request)
    {
        $datas = $this->repo->index($request);
        if (auth()->user()->hasRole('koor')) {
            return view('pages.dashboard.request.instructor.index', compact('datas'));
        } elseif (auth()->user()->hasRole('kabid')) {
            return view('pages.dashboard.request.division.index', compact('datas'));
        } elseif (auth()->user()->hasRole('kadis')) {
            return view('pages.dashboard.request.coordinator.index', compact('datas'));
        }
    }

    public function create()
    {
        $datas = $this->repo->create();
        return view('pages.dashboard.request.instructor.create', compact('datas'));
    }

    public function store(StoreRequestRequest $request)
    {
        $validated = $request->validated();
        if ($this->repo->store($validated)) {
            return to_route('dashboard.request.index')->with(
                [
                    'created'   =>  __('message.request.created')
                ]
            );
        }
        return to_route('dashboard.request.index')->with(
            [
                'failed'   =>  __('message.request.notCreated')
            ]
        );
    }

    public function update(UpdateRequestRequest $request, ModelsRequest $instructorRequest)
    {
        $validated = $request->validated();
        if ($this->repo->update($validated, $instructorRequest)) {
            return back()->with(
                [
                    'created'   =>  __('message.request.updated')
                ]
            );
        }
        return back()->with(
            [
                'failed'   =>  __('message.request.notUpdated')
            ]
        );
    }

    public function show(ModelsRequest $request)
    {
        $datas = $this->repo->show($request);
        if (auth()->user()->hasRole('koor')) {
            return view('pages.dashboard.request.instructor.show', compact('datas'));
        } elseif (auth()->user()->hasRole('kabid')) {
            return view('pages.dashboard.request.division.show', compact('datas'));
        } elseif (auth()->user()->hasRole('kadis')) {
            return view('pages.dashboard.request.coordinator.show', compact('datas'));
        }
    }

    public function destroy(ModelsRequest $request)
    {
        if ($request->delete()) {
            return back()->with(
                [
                    'destroyed'   =>  __('message.request.deleted')
                ]
            );
        }

        return back()->with(
            [
                'failed'    =>  __('message.request.notDeleted')
            ]
        );
    }

    public function destroyAttachment(ModelsRequest $request, RequestAttachment $attachment)
    {
        if ($this->repo->destroyAttachment($attachment)) {
            return back()->with(
                [
                    'destroyed'   =>  __('message.attachment.deleted')
                ]
            );
        }

        return back()->with(
            [
                'failed'    =>  __('message.attachment.notDeleted')
            ]
        );
    }
}
