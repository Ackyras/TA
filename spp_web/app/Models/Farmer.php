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
}
