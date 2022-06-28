<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function cities(){
        return $this->belongsTo(State::class);
    }

    public function address(){
        return $this->hasMany(Address::class);
    }
}
