<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address'; //Arrumando o nome da tabela, pois foi criado a migration com o nome errado
    public function state(){
        return $this->belongsTo(State::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function real_state(){
        return $this->hasOne(RealState::class);
    }
}
