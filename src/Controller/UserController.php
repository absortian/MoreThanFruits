<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class UserController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function homepage(Request $request){

        if($this->checkUser()){
            return new Response(
                $this->renderView("user/home.html.twig", array(

                ))
            );
        }else{
            return $this->redirectToRoute('user_login');
        }
        
    }

    /**
     * @Route("/tokens", name="tokens")
     */
    public function tokens(Request $request){

        if($this->checkUser()){
            return new Response(
                $this->renderView("user/tokens.html.twig", array(

                ))
            );
        }else{
            return $this->redirectToRoute('user_login');
        }
        
    }

    /**
     * @Route("/users", name="users")
     */
    public function users(Request $request){

        $user = $this->getUser();

        if($user instanceof User && in_array("ROLE_ADMIN", $user->getRoles())){
            return new Response(
                $this->renderView("user/users.html.twig", array(

                ))
            );
        }else{
            return $this->redirectToRoute('user_login');
        }
        
    }

    /**
     * @Route("/fruits", name="fruits")
     */
    public function fruits(Request $request){

        $user = $this->getUser();

        if($user instanceof User && in_array("ROLE_ADMIN", $user->getRoles())){
            return new Response(
                $this->renderView("user/fruits.html.twig", array(

                ))
            );
        }else{
            return $this->redirectToRoute('user_login');
        }
        
    }

    /**
     * @Route("/orders", name="orders")
     */
    public function orders(Request $request){

        $user = $this->getUser();

        if($user instanceof User){
            return new Response(
                $this->renderView("user/orders.html.twig", array(

                ))
            );
        }else{
            return $this->redirectToRoute('user_login');
        }
        
    }

    // Función auxiliar que comprueba si está logeado.
    public function checkUser(){

        $user = $this->getUser();

        if($user instanceof User){
            return true;
        }
        
        return false;        
    }
}