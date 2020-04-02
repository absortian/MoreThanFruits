<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Fruit;
use App\Event\FruitCreatedEvent;
use DateTime;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class FruitService extends AbstractController
{

    public function __construct(EventDispatcherInterface $eventDispatcher){
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * deleteFruit Elimina una fruta.
     */
    public function deleteFruit($fruitName){
        
        // Respuesta por defecto
        $response = array(
            "status" => false,
            "message" => "Error inesperado eliminando fruta."
        );
        
        if(isset($fruitName) && is_string($fruitName) && !empty($fruitName)){

            $em = $this->getDoctrine()->getManager();

            $fruit = $em->getRepository("App:Fruit")->findOneByName($fruitName);
            
            if($fruit){
                $em->remove($fruit);
                $em->flush();
            }

            $response = array(
                "status" => true,
                "message" => "Fruta eliminada correctamente."
            );
        }else{

            $response = array(
                "status" => false,
                "message" => "Nombre fruta no válido."
            );

        }

        return $response;

    }

    /**
     * createFruit Crea una fruta.
     */
    public function createFruit($fruitName){
        
        // Respuesta por defecto
        $response = array(
            "status" => false,
            "message" => "Error inesperado creando fruta."
        );
        
        if(isset($fruitName) && is_string($fruitName) && !empty($fruitName)){

            $em = $this->getDoctrine()->getManager();

            $fruitCheck = $em->getRepository("App:Fruit")->findOneByName($fruitName);
            if(!$fruitCheck){
                $fruit = new Fruit();
                $fruit->setName($fruitName);
                $em->persist($fruit);
                $em->flush($fruit);
                // Lanzamos evento de fruta registrada
                $event = new FruitCreatedEvent($fruit);
                $this->eventDispatcher->dispatch(FruitCreatedEvent::NAME, $event);
                $response = array(
                    "status" => true,
                    "message" => "Fruta creada correctamente.",
                    "data" => array(
                        "fruit" => $fruit,
                    )
                );
            }else{
                $response = array(
                    "status" => false,
                    "message" => "La fruta ya existe en la plataforma."
                );
            }
        }else{

            $response = array(
                "status" => false,
                "message" => "Nombre fruta no válido."
            );

        }

        return $response;

    }
    

}