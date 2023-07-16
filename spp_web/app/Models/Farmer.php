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

    public function requests()
    {
        return $this->belongsToMany(Program::class, 'requests')
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
}
