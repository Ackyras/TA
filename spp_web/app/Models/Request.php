<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('current_period', function ($query) {
            $query->where('period_id', Period::query()->where('is_active', true)->first()->id);
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
