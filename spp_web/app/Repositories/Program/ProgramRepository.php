<?php

namespace App\Repositories\Program;

use App\Models\Program;
use App\Models\Division;

class ProgramRepository extends BaseProgramRepository
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
        return Division::query()
            ->when(
                auth()->user()->hasRole('kabid'),
                function ($query) {
                    $query->whereHas('users', function ($query) {
                        $query->where('users.id', auth()->user()->id);
                    });
                }
            )
            ->with(
                [
                    'programs' => function ($query) {
                        $query->whereNull('parent_id')->with('lowerProgramTree');
                    },
                ]
            )->get();
    }

    public function store(array $data)
    {
        // dd($data);
        return Program::create($data);
    }

    public function update(Program $program, array $data)
    {
        // dd($data);
        return $program->update($data);
    }

    public function prepareDatatable($datas, $config = null)
    {
        $config = $this->datatableConfig;
        $config['actions'] = $this->indexTableAction;
        return parent::prepareDatatable($datas, $config);
    }
}
