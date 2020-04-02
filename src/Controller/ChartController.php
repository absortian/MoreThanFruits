<?php
namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ChartController extends AbstractController
{

    /**
     * @Route("/charts/getOrdersPerDay", name="getOrdersPerDay")
     */
    public function getOrdersPerDay(Request $request){

        // Respuesta por defecto
        $response = array(
            "status" => false,
            "message" => "No se ha podido completar"
        );

        $user = $this->getUser();

        if($user instanceof User){

            $entityManager = $this->getDoctrine()->getManager();

            $params = $request->request->all();

            $params["user"] = $user->getId();

            $resultQuery = $entityManager->getRepository("App:FruitOrder")->getOrdersPerDay($params);

            $response = array(

                "status" => true,
    
                "data" => $resultQuery
    
            );
            
        }
        
        return new Response(json_encode($response));

    }

}