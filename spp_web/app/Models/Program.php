<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'parent_id',
        'period_id',
    ];

    public function __boot()
    {
        parent::boot();
        $periodId = request()->route()->hasParameter('period')
            ? (int) request()->route()->parameter('period')
            : getCurrentPeriodId();

        static::addGlobalScope('current_period', function ($query) use ($periodId) {
            $query->where('period_id', $periodId)
                ->with(['program']); // Eager load the "program" relationship
        });
    }

    public function subPrograms()
    {
        return $this->hasMany(Program::class, 'parent_id');
    }

    public function upperProgram()
    {
        return $this->belongsTo(Program::class, 'parent_id');
    }

    public function upperProgramTree()
    {
        return $this->belongsTo(Program::class, 'parent_id')->with('upperProgramTree');
    }

    public function lowerProgramTree()
    {
        return $this->hasMany(Program::class, 'parent_id')
            ->with(
                'lowerProgramTree',
                'proposalDictionaries'
            );
    }

    public function proposalDictionaries()
    {
        return $this->hasMany(ProposalDictionary::class, 'parent_id');
    }

    // public function division()
    // {
    //     return $this->belongsTo(Division::class);
    // }

    // public function period()
    // {
    //     return $this->belongsTo(Period::class);
    // }

    // public function farmers()
    // {
    //     return $this->belongsToMany(Farmer::class, 'requests')
    //         ->using(Request::class)
    //         ->withPivot(
    //             [
    //                 'id',
    //                 'volume',
    //                 'status',
    //                 'unit_id',
    //             ]
    //         )->withTimestamps();
    // }

    // public function requests()
    // {
    //     return $this->hasMany(Request::class);
    // }
}
