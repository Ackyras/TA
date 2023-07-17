<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'division_id',
        'code',
        'is_parent',
        'parent_id',
        'period_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('current_period', function ($query) {
            // Define your scope conditions here
            $query->where('programs.period_id', Period::query()->where('is_active', true)->first()->id);
        });
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
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
        return $this->hasMany(Program::class, 'parent_id')->with('lowerProgramTree');
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function farmers()
    {
        return $this->belongsToMany(Farmer::class, 'requests')
            ->using(Request::class)
            ->withPivot(
                [
                    'id',
                    'volume',
                    'status',
                    'unit_id',
                ]
            )->withTimestamps();
    }

    public function requests()
    {
        return $this->hasMany(Request::class);
    }
}
