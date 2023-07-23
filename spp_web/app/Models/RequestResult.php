<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'volume',
        'unit_id',
        'request_id',
    ];

    public function request()
    {
        return $this->belongsTo(Request::class);
    }

    public function attachments()
    {
        return $this->hasMany(RequestResultAttachment::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
