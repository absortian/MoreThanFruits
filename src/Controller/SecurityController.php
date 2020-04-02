<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Service\UserService;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="user_login")
     */
    public function userLogin(Request $request, UserPasswordEncoderInterface $encoder){

        // Comprobamos si está logeado
        if(!$this->checkUser()){
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
                // Obtenemos EM
                $em = $this->getDoctrine()->getManager();
                $user = $em->getRepository("App:User")->findOneBy(array(
                    "email" => $_POST["email"],
                    "enabled" => true
                ));
                if($user){
                    if($encoder->isPasswordValid($user, $_POST["password"])){
                        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
                        $this->get('security.token_storage')->setToken($token);
                        $this->get('session')->set('_security_main', serialize($token));
                        return $this->redirectToRoute('home');
                    }else{
                        return $this->render('security/login.html.twig', array(
                            "errorPassword" => true
                        ));
                    }
                    return $this->render('security/login.html.twig');
                }else{
                    return $this->render('security/login.html.twig', array(
                        "errorUser" => true
                    ));
                }
            }
            return $this->render('security/login.html.twig');
        }else{
            return $this->redirectToRoute('home');
        }
    }
    

    /**
     * @Route("/register", name="user_register")
     */
    /*
    public function userRegister(Request $request, UserPasswordEncoderInterface $encoder, UserService $userService){

        // Comprobamos si está logeado
        if(!$this->checkUser()){
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Obtenemos EM
                $em = $this->getDoctrine()->getManager();
                $User = $em->getRepository("App:User")->findOneByEmail($_POST["email"]);
                if($User){
                    return $this->render('security/register.html.twig', array(
                        "errorUser" => true
                    ));
                }else{
                    if($_POST["password"] == $_POST["passwordTwo"]){
                        $checkUserCreation = $userService->registerUser($_POST["email"], $_POST["password"]);
                        if(isset($checkUserCreation["status"]) && $checkUserCreation["status"] === true){
                            try {
                                $user = $checkUserCreation["data"]["user"];
                                if($encoder->isPasswordValid($user, $_POST["password"])){
                                    $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
                                    $this->get('security.token_storage')->setToken($token);
                                    $this->get('session')->set('_security_main', serialize($token));
                                    return $this->redirectToRoute('home');
                                }
                            } catch (\Throwable $th) {
                                return $this->render('security/register.html.twig');
                            }
                            
                        }else{
                            return $this->render('security/register.html.twig');
                        }
                    }else{
                        return $this->render('security/register.html.twig', array(
                            "errorPassword" => true
                        ));
                    }
                    return $this->render('security/register.html.twig');
                }
            }
            return $this->render('security/register.html.twig');
        }else{
            return $this->redirectToRoute('home');
        }
    }
    */

    /**
     * @Route("/backend/logout", name="backend_logout")
     */
    public function backendLogout(Request $request){
        if($this->checkUser()){
            $this->get('security.token_storage')->setToken(null);
            $this->get('session')->set('_security_main', serialize(null));
        }
        return $this->redirectToRoute('user_login');
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
