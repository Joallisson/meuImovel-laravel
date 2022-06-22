<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealStatePhoto extends Model
{
    protected $fillable = [
        'photo',
        'is_thumb'
    ];

    public function realState(){
        return $this->belongsTo(realState::class);
    }
}
