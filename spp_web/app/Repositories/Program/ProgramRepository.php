<?php

namespace App\Repositories\Program;

use App\Models\Program;
use App\Models\Division;
use App\Models\ProposalDictionary;

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
        return Program::query()
            ->whereNull('parent_id')
            ->with(
                [
                    'lowerProgramTree'
                ]
            )->get();
    }

    public function store(array $data)
    {
        if ($program = Program::create($data)) {
            return true;
        }
        return false;
    }

    public function update(Program $program, array $data)
    {
        // dd($data);
        if ($program->update($data)) {
            return $program->update($data);
        }
        return false;
    }

    public function prepareDatatable($datas, $config = null)
    {
        $config = $this->datatableConfig;
        $config['actions'] = $this->indexTableAction;
        return parent::prepareDatatable($datas, $config);
    }

    public function dictionaryIndex()
    {
        $datas = [];
        $programs = Program::query()
            ->whereNull('parent_id')
            ->with(
                [
                    'lowerProgramTreeAndDictionaries',
                    'proposalDictionaries'
                ]
            )->get();

        // Debugging statement
        // dd($programs);

        return $programs;
    }


    public function dictionaryStore(array $datas)
    {
        if ($dictionary = ProposalDictionary::create($datas)) {
            return true;
        }
        return false;
    }

    public function dictionaryUpdate(array $datas, $proposalDictionary)
    {
        if ($dictionary = $proposalDictionary->update($datas)) {
            return true;
        }
        return false;
    }
}
