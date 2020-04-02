<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\Event;

class FruitOrderCreatedEvent extends Event{

    public const NAME = "event.FruitOrderCreated";

    public function __construct($data){
        $this->data = $data;
    }

}