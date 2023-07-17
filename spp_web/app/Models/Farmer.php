<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'pic',
        'village_id',
    ];

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'requests')
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
