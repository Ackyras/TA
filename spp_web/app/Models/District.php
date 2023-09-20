<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function villages()
    {
        return $this->hasMany(Village::class);
    }

    public function farmers()
    {
        return $this->hasManyThrough(Farmer::class, Village::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_district')->using(UserDistrict::class);
    }
}
