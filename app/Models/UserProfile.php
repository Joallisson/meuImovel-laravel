<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = 'user_profile'; //Estou dizendo pro model que esse é o nome da tabela //isso é uma gabiarra pois lá na tabela o nome deve sempre ser no plural
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
