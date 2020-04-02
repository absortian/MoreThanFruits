<?php

namespace App\EventSubscriber;

use App\Event\UserRegisterEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserRegisterSubscriber implements EventSubscriberInterface{

    public function onUserRegister($event){
        // Usuario registrado
    }

    public static function getSubscribedEvents(){
        return [
            UserRegisterEvent::NAME => "onUserRegister"
        ];
    }

}