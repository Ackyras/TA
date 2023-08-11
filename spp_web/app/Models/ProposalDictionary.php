<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalDictionary extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'division_id',
        'program_id',
        'parent_id'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
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
