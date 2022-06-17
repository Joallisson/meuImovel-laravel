<?php

namespace App\Api\ApiMessages;

class ApiMessages{

    private $message = [];

    public function __construct(string $message, array $data = []){

        $this->message['message'] = $message;
        $this->message['errors'] = $data;
    }

    public function getMessege(){

        return $this->message;
    }
}