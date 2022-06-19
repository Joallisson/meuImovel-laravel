<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'phone',
        'mobile_phone',
        'about',
        'social_network'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
