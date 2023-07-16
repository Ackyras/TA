<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'farmer_id',
        'support_id',
        'period_id',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('current_period', function ($query) {
            // Define your scope conditions here
            $query->where('period_id', Period::query()->where('is_active', true)->first()->id);
        });
    }
}
