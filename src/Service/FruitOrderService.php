<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\FruitOrder;
use App\Event\FruitOrderCreatedEvent;
use DateTime;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class FruitOrderService extends AbstractController
{

    public function __construct(EventDispatcherInterface $eventDispatcher){
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * createFruitOrder Crea una orden de frutas.
     */
    public function createFruitOrder($providerName, $countryCode, $phone, $providerId, $fruitName, $amount){
        
        // Respuesta por defecto
        $response = array(
            "status" => false,
            "message" => "Error inesperado creando pedido."
        );
        
        if(isset($providerName) && is_string($providerName) && !empty($providerName)){
            if(isset($countryCode) && is_string($countryCode) && $countryCode == "+34"){
                if(isset($phone) && is_string($phone) && !empty($phone)){
                    if(isset($providerId) && is_string($providerId) && !empty($providerId)){
                        if(isset($fruitName) && is_string($fruitName) && !empty($fruitName)){
                            if(isset($amount) && is_numeric($amount) && $amount > 0){

                                $em = $this->getDoctrine()->getManager();

                                $order = new FruitOrder();
                                $order->setProviderName($providerName);
                                $order->setCountryCode($countryCode);
                                $order->setPhone($phone);
                                $order->setProviderId($providerId);
                                $order->setFruitName($fruitName);
                                $order->setAmount($amount);
                                $order->setCreationDate(new DateTime());
                                $em->persist($order);
                                $em->flush($order);

                                // Lanzamos evento de usuario registrado
                                $event = new FruitOrderCreatedEvent($order);
                                $this->eventDispatcher->dispatch(FruitOrderCreatedEvent::NAME, $event);

                                $response = array(
                                    "status" => true,
                                    "message" => "Orden creada correctamente.",
                                    "data" => array(
                                        "order" => $order,
                                    )
                                );
                            }else{
                                $response = array(
                                    "status" => false,
                                    "message" => "Cantidad no válida."
                                );  
                            }
                        }else{
                            $response = array(
                                "status" => false,
                                "message" => "Fruta no válida."
                            );  
                        }
                    }else{
                        $response = array(
                            "status" => false,
                            "message" => "ID Proveedor no válido."
                        ); 
                    }
                }else{
                    $response = array(
                        "status" => false,
                        "message" => "Teléfono no válido."
                    ); 
                }
            }else{

                $response = array(
                    "status" => false,
                    "message" => "Código de país no válido."
                );

            }
        }else{

            $response = array(
                "status" => false,
                "message" => "Nombre proveedor no válido."
            );

        }

        return $response;

    }
    

}