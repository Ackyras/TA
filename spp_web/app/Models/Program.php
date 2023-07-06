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
    ];

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
}
