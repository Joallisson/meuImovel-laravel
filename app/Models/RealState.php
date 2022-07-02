<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealState extends Model
{
    protected $appends = ['thumb']; //adicionado esse atributo no retorno da tabela real_states //Retornando a thumb mail
    //protected $appends = ['links']; //adicionado esse atributo no retorno da tabela real_states

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'content',
        'price',
        'bathrooms',
        'bedrooms',
        'property_area',
        'total_property_area',
        'slug'
    ];

    //depois arrumar esse link dinamico //O NOME DESSE CONCEITO DE CRIAR LINKS DINÂMICOS NO LARAVEL SE CHAMA: ACCESSORS
    // public function getLinksAttribute(){ //chamando o atributo links toda vez que retorna todos os atributos tabela real_states
    //     return [
    //         'href' => route('real_states.real-states.show', ['realState' => $this->id]),
    //         'rel' => 'Imovéis'
    //     ];
    // }

    public function getThumbAttribute(){ //Retornando a thumb mail
        $thumb = $this->photos()->where('is_thumb', true);

        if(!$thumb->count()) return null; //senão tiver thumb retorna null

        return $thumb->first()->photo;
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function photos(){
        return $this->hasMany(RealStatePhoto::class);
    }

    public function address(){
        return $this->belongsTo(Address::class);
    }
}
