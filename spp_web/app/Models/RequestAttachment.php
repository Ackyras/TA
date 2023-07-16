<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
        'request_id',
    ];

    public function request()
    {
        return $this->belongsTo(Request::class);
    }
}
