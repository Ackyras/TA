<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nickname',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->using(DivisionUser::class);
    }

    public function programs()
    {
        return $this->hasMany(Program::class);
    }
}