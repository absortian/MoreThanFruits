<?php

namespace App\EventSubscriber;

use App\Event\FruitOrderCreatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FruitOrderCreatedSubscriber implements EventSubscriberInterface{

    public function onFruitOrderCreated($event){
        // Orden creada
    }

    public static function getSubscribedEvents(){
        return [
            FruitOrderCreatedEvent::NAME => "onFruitOrderCreated"
        ];
    }

}