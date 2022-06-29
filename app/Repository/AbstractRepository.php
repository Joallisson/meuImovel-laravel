<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

class AbstractRepository{

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function selectCoditions($coditions){ //divide as condições da pesquisa

        $expressions = explode(';', $coditions); //estado:=:maranhão;cidade:like:balas
        foreach($expressions as $e){ //cidade:like:balas
            $exp = explode(':', $e); //[0 => cidade, 1 => like, 2 => balsas]

            $this->model = $this->model->where($exp[0], $exp[1], $exp[2]); //cidade like balsas
        }
    }

    public function selectFilter($filters){
        $this->model = $this->model->selectRaw($filters); //selectRaw => dá para retornar vários campos do db separando coma vírgula
    }

    public function getResult(){
        return $this->model;
    }
}
