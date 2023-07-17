<?php

namespace App\Repositories\Request;

use App\Models\Unit;
use App\Models\Farmer;
use App\Models\Period;
use App\Models\Program;
use App\Models\Request;
use App\Models\Division;
use App\Models\RequestAttachment;
use Illuminate\Support\Facades\Storage;

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

    public function index()
    {
        $datas = [];
        $datas = Request::query()
            ->whereHas('farmer', function ($query) {
                $query->whereHas('village', function ($query) {
                    $query->whereHas('users', function ($query) {
                        $query->where('users.id', auth()->id());
                    });
                });
            })
            ->with([
                'attachments',
                'farmer',
                'program',
                'unit'
            ])
            ->get()
            ->groupBy('farmer') // Group the result by the farmer
            //
        ;
        // dd($datas);
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
        // dd($datas['units']);
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
        // dd($datas['programs']);
        return $datas;
    }

    public function store(array $data)
    {
        $data['period_id'] = Period::query()->where('is_active', true)->first()->id;
        $request = Request::create($data);
        $request->refresh();
        if ($request) {
            foreach ($data['attachments'] as $attachmentData) {
                // Save the uploaded file to storage
                $file = $attachmentData['file'];
                $filePath = $file->store('request/attachments');

                // Create the attachment record with name and URL
                $attachment = new RequestAttachment([
                    'name' => $attachmentData['name'],
                    'url' => str(Storage::url($filePath)),
                ]);

                // Attach the attachment to the request
                $request->attachments()->save($attachment);
            }
            return true;
        }

        return false;
    }

    public function update(array $data, Request $request)
    {
        $data['period_id'] = Period::query()->where('is_active', true)->first()->id;
        $request->update($data);
        $request->refresh();
        if ($data['attachments']) {
            foreach ($data['attachments'] as $attachmentData) {
                // Save the uploaded file to storage
                $file = $attachmentData['file'];
                $filePath = $file->store('request/attachments');

                // Create the attachment record with name and URL
                $attachment = RequestAttachment::create([
                    'name' => $attachmentData['name'],
                    'url' => str(Storage::url($filePath)),
                    'request_id' => $request->id
                ]);
            }
            return true;
        }

        return false;
    }



    public function getPrograms(bool $asArray = false)
    {
        $programs = Program::query()
            ->whereNull('parent_id')
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

    public function prepareDatatable($datas, $config = null)
    {
        $config = $this->datatableConfig;
        $config['actions'] = $this->indexTableAction;
        return parent::prepareDatatable($datas, $config);
    }
}
