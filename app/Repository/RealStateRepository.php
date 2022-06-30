<?php

namespace App\Repository;

class RealStateRepository extends AbstractRepository{

    private $location = [];

    public function setLocation(array $data): self{
        $this->location = $data;
        return $this;

    }

    public function getResult()
    {

        return $this->model->whereHas('address', function($query){
                        $query->where('state_id', $this->location['state'])
                        ->where('city_id', $this->location['city']);
                    });
    }
}
