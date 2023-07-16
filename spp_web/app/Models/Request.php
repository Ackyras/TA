<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Request extends Pivot
{
    use HasFactory;

    protected $table = 'requests';

    protected $fillable = [
        'farmer_id',
        'support_id',
        'period_id',
        'status',
        'volume',
        'unit_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('current_period', function ($query) {
            // Define your scope conditions here
            $query->where('requests.period_id', Period::query()->where('is_active', true)->first()->id);
        });
    }

    public function attachments()
    {
        return $this->hasMany(RequestAttachment::class, 'request_id', 'id');
    }

    public function farmer()
    {
        return $this->belongsTo(Farmer::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
