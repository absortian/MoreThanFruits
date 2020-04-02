<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\Event;

class UserRegisterEvent extends Event{

    public const NAME = "event.UserRegister";

    public function __construct($data){
        $this->data = $data;
    }

}