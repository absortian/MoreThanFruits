<?php

namespace App\EventSubscriber;

use App\Event\FruitCreatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FruitCreatedSubscriber implements EventSubscriberInterface{

    public function onFruitCreated($event){
        // Fruta creada
    }

    public static function getSubscribedEvents(){
        return [
            FruitCreatedEvent::NAME => "onFruitCreated"
        ];
    }

}