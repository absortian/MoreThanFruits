<?php
namespace App\Controller;

use App\Service\APIService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepage(){

        //$entityManager = $this->getDoctrine()->getManager();

        return new Response(
            $this->renderView("front/front.html.twig")
        );
    }

    /**
     * @Route("/quienes-somos", name="aboutUs")
     */
    public function aboutUs(){
        return new Response(
            $this->renderView("front/aboutUs.html.twig")
        );
    }

    /**
     * @Route("/contacta", name="contact")
     */
    public function contact(){
        return new Response(
            $this->renderView("front/contact.html.twig")
        );
    }

    /**
     * @Route("/cookies", name="cookies")
     */
    public function cookies(){
        return new Response(
            $this->renderView("front/cookies.html.twig")
        );
    }

    /**
     * @Route("/aviso-legal", name="legalAdvise")
     */
    public function legalAdvise(){
        return new Response(
            $this->renderView("front/advise.html.twig")
        );
    }

    /**
     * @Route("/politica-privacidad", name="privacity")
     */
    public function privacity(){
        return new Response(
            $this->renderView("front/privacy.html.twig")
        );
    }
    
}