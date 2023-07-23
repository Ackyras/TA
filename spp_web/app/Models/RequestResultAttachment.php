<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestResultAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'url',
    ];

    public function requestResult()
    {
        return $this->belongsTo(RequestResult::class);
    }
}
