<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\Event;

class FruitCreatedEvent extends Event{

    public const NAME = "event.FruitCreated";

    public function __construct($data){
        $this->data = $data;
    }

}