<?php

namespace App\Repositories\Request;

use App\Models\Unit;
use App\Models\Farmer;
use App\Models\Period;
use App\Models\Program;
use App\Models\Request;
use App\Models\Division;
use App\Models\RequestAttachment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request as HttpRequest;

class RequestRepository extends BaseRequestRepository
{
    protected $indexTableAction = [
        'show' => [
            'text'  =>  'Lihat',
            'type'  =>  'redirect',
            'route' =>  'dashboard.setting.program.show',
            'color' =>  'primary',
        ],
        'destroy' => [
            'text'  =>  'Hapus',
            'type'  =>  'delete',
            'route' =>  'dashboard.setting.program.destroy',
            'color' =>  'danger',
        ],
    ];

    protected $allowedFilters = [
        'status',
        'program_id'
    ];

    public function index(HttpRequest $request)
    {
        $datas = [];
        $query = Request::query()
            ->when(
                auth()->user()->hasRole('koor'),
                function ($query) {
                    $query->whereHas('farmer', function ($query) {
                        $query->whereHas('village', function ($query) {
                            $query->whereHas('users', function ($query) {
                                $query->where('users.id', auth()->id());
                            });
                        });
                    })->orderByRaw(
                        "CASE
                            WHEN status = 'approved' THEN 0
                            WHEN status = 'requested' THEN 1
                            WHEN status = 'pending' THEN 2
                            WHEN status = 'done' THEN 3
                            WHEN status = 'declined' THEN 4
                            ELSE 3
                        END"
                    );
                }
            )
            ->when(
                auth()->user()->hasRole('kabid'),
                function ($query) {
                    $query->whereHas('program', function ($query) {
                        $query->whereHas('division', function ($query) {
                            $query->whereHas('users', function ($query) {
                                $query->where('users.id', auth()->id());
                            });
                        });
                    })->with(
                        [
                            'result'    =>  [
                                'attachments',
                                'unit'
                            ]
                        ]
                    )->orderByRaw(
                        "CASE
                            WHEN status = 'pending' THEN 0
                            WHEN status = 'requested' THEN 1
                            WHEN status = 'approved' THEN 2
                            WHEN status = 'done' THEN 3
                            WHEN status = 'declined' THEN 4
                            ELSE 3
                        END"
                    );
                }
            )
            ->when(
                auth()->user()->hasRole('kadis'),
                function ($query) {
                    $query->with(
                        [
                            'result'    =>  [
                                'attachments',
                                'unit'
                            ],
                        ]
                    )->orderByRaw(
                        "CASE
                            WHEN status = 'requested' THEN 0
                            WHEN status = 'approved' THEN 1
                            WHEN status = 'pending' THEN 2
                            WHEN status = 'done' THEN 3
                            WHEN status = 'declined' THEN 4
                            ELSE 3
                        END"
                    );
                }
            )
            ->with(
                [
                    'attachments',
                    'farmer',
                    'program',
                    'unit'
                ]
            );
        $datas['paginator'] = $this->filter($query, $request, false, true, 10)->withQueryString();
        $datas['items'] = $datas['paginator']->groupBy('farmer');
        $datas['programs'] = $this->getPrograms(true);
        return $datas;
    }

    public function create()
    {
        $datas = [];
        $datas['units'] = Unit::all();
        $datas['farmers'] = Farmer::query()
            ->whereRelation('village.users', 'users.id', auth()->id())
            ->select(['name', 'address', 'pic', 'village_id', 'id'])
            ->with([
                'village' => function ($query) {
                    $query->select(['id', 'name', 'district_id']);
                },
                'village.district' => function ($query) {
                    $query->select(['id', 'name']);
                }
            ])
            ->get();
        $datas['programs'] = $this->getPrograms(true);
        return $datas;
    }

    public function show(Request $request)
    {
        $datas = [];
        $datas['request'] = $request->load(
            [
                'farmer',
                'attachments',
                'program.division'
            ]
        );
        $datas['programs'] = $this->getPrograms(true);
        $datas['units'] = Unit::all();
        return $datas;
    }

    public function store(array $data)
    {
        $data['period_id'] = Period::query()->where('is_active', true)->first()->id;
        $request = Request::create($data);
        $request->refresh();
        if ($request) {
            foreach ($data['attachments'] as $attachmentData) {
                $this->storeAttachment($request, $attachmentData);
            }
            return true;
        }
        return false;
    }

    public function update(array $data, Request $request)
    {
        $data['period_id'] = getCurrentPeriodId();
        // dd($data);
        $request->update($data);
        $request->refresh();
        if (isset($data['attachments'])) {
            foreach ($data['attachments'] as $attachmentData) {
                $this->storeAttachment($request, $attachmentData);
            }
        }
        return true;
    }

    public function storeAttachment(Request $request, $attachmentData)
    {
        $file = $attachmentData['file'];
        $fileName = $file->hashName();

        $storeFile = Storage::disk('local')->putFileAs(
            'request/attachment',
            $file,
            $fileName
        );

        // Create the attachment record with name and URL
        return RequestAttachment::create([
            'name' => $attachmentData['name'],
            'url' => $storeFile,
            'request_id' => $request->id,
        ]);
    }

    public function getPrograms(bool $asArray = false)
    {
        $programs = Program::query()
            ->whereNull('parent_id')
            ->when(
                auth()->user()->hasRole('kabid'),
                function ($query) {
                    $query->whereHas('division', function ($query) {
                        $query->whereHas('users', function ($query) {
                            $query->where('users.id', auth()->id());
                        });
                    });
                }
            )
            ->with(
                [
                    'lowerProgramTree',
                    'division'
                ]
            )
            ->get();
        if ($asArray) {
            return $programs->toArray();
        }
        return $programs;
    }

    public function destroyAttachment(RequestAttachment $attachment)
    {
        if ($attachment->delete() && Storage::disk('local')->delete($attachment->url)) {
            return true;
        }
        return false;
    }

    public function prepareDatatable($datas, $config = null)
    {
        $config = $this->datatableConfig;
        $config['actions'] = $this->indexTableAction;
        return parent::prepareDatatable($datas, $config);
    }
}
