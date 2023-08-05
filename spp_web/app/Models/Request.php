<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Request extends Model
{
    use HasFactory;

    protected $table = 'requests';

    protected $fillable = [
        'farmer_id',
        'support_id',
        'period_id',
        'program_id',
        'status',
        'volume',
        'unit_id',
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

    public function attachments()
    {
        return $this->hasMany(RequestAttachment::class);
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

    public function result()
    {
        return $this->hasOne(RequestResult::class);
    }
}
