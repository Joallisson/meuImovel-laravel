<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
        'slug'
    ];

    public function realStates(){
        return $this->hasMany(RealState::class, 'real_state_categories');
    }
}
