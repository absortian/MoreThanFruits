<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Entity\UserToken;
use App\Service\APIService;
use Symfony\Component\Serializer\Encoder\JsonDecode;

class APIController extends AbstractController
{

    /**
     * @Route("/api/delete/fruit", name="api_delete_fruit")
     */
    public function apiDeleteFruit(Request $request, APIService $apiService){
        // Respuesta por defecto
        $response = array(
            "status" => false,
            "message" => "Error inesperado, prueba más tarde."
        );
        // Intentamos obtener datos tipo JSON
        $data = json_decode($request->getContent(), true);
        if(!$data){
            // Obtenemos data de form
            $data = $request->request->all();
        }
        $user = $this->getUser();
        if($user instanceof User){
            $data["user"] = $user;
        }
        $response = $apiService->apiDeleteFruit($data);
        return new JsonResponse($response);
    }

    /**
     * @Route("/api/create/fruit", name="api_create_fruit")
     */
    public function apiCreateFruit(Request $request, APIService $apiService){
        // Respuesta por defecto
        $response = array(
            "status" => false,
            "message" => "Error inesperado, prueba más tarde."
        );
        // Intentamos obtener datos tipo JSON
        $data = json_decode($request->getContent(), true);
        if(!$data){
            // Obtenemos data de form
            $data = $request->request->all();
        }
        $user = $this->getUser();
        if($user instanceof User){
            $data["user"] = $user;
        }
        $response = $apiService->apiCreateFruit($data);
        return new JsonResponse($response);
    }

    /**
     * @Route("/api/create/order", name="api_create_order")
     */
    public function apiCreateOrder(Request $request, APIService $apiService){
        // Respuesta por defecto
        $response = array(
            "status" => false,
            "message" => "Error inesperado, prueba más tarde."
        );
        // Intentamos obtener datos tipo JSON
        $data = json_decode($request->getContent(), true);
        if(!$data){
            // Obtenemos data de form
            $data = $request->request->all();
        }
        $user = $this->getUser();
        if($user instanceof User){
            $data["user"] = $user;
        }
        $response = $apiService->apiCreateOrder($data);
        return new JsonResponse($response);
    }

    /**
     * @Route("/api/create/user", name="api_create_user")
     */
    public function apiCreateUser(Request $request, APIService $apiService){
        // Respuesta por defecto
        $response = array(
            "status" => false,
            "message" => "Error inesperado, prueba más tarde."
        );
        // Intentamos obtener datos tipo JSON
        $data = json_decode($request->getContent(), true);
        if(!$data){
            // Obtenemos data de form
            $data = $request->request->all();
        }
        $user = $this->getUser();
        if($user instanceof User){
            $data["user"] = $user;
        }
        $response = $apiService->apiCreateUser($data);
        return new JsonResponse($response);
    }

    /**
     * @Route("/api/enable/user", name="api_enable_user")
     */
    public function apiEnableUser(Request $request, APIService $apiService){
        // Respuesta por defecto
        $response = array(
            "status" => false,
            "message" => "Error inesperado, prueba más tarde."
        );
        // Intentamos obtener datos tipo JSON
        $data = json_decode($request->getContent(), true);
        if(!$data){
            // Obtenemos data de form
            $data = $request->request->all();
        }
        $user = $this->getUser();
        if($user instanceof User){
            $data["user"] = $user;
        }
        $response = $apiService->apiEnableUser($data);
        return new JsonResponse($response);
    }

    /**
     * @Route("/api/disable/user", name="api_disable_user")
     */
    public function apiDisableUser(Request $request, APIService $apiService){
        // Respuesta por defecto
        $response = array(
            "status" => false,
            "message" => "Error inesperado, prueba más tarde."
        );
        // Intentamos obtener datos tipo JSON
        $data = json_decode($request->getContent(), true);
        if(!$data){
            // Obtenemos data de form
            $data = $request->request->all();
        }
        $user = $this->getUser();
        if($user instanceof User){
            $data["user"] = $user;
        }
        $response = $apiService->apiDisableUser($data);
        return new JsonResponse($response);
    }

    /**
     * @Route("/api/get/orders", name="api_get_orders")
     */
    public function apiGetOrders(Request $request, APIService $apiService){
        // Respuesta por defecto
        $response = array(
            "status" => false,
            "message" => "Error inesperado, prueba más tarde."
        );
        // Intentamos obtener datos tipo JSON
        $data = json_decode($request->getContent(), true);
        if(!$data){
            // Obtenemos data de form
            $data = $request->request->all();
        }
        $user = $this->getUser();
        if($user instanceof User){
            $data["user"] = $user;
        }
        $response = $apiService->apiGetOrders($data);
        return new JsonResponse($response);
    }

    /**
     * @Route("/api/get/fruits", name="api_get_fruits")
     */
    public function apiGetFruits(Request $request, APIService $apiService){
        // Respuesta por defecto
        $response = array(
            "status" => false,
            "message" => "Error inesperado, prueba más tarde."
        );
        // Intentamos obtener datos tipo JSON
        $data = json_decode($request->getContent(), true);
        if(!$data){
            // Obtenemos data de form
            $data = $request->request->all();
        }
        $user = $this->getUser();
        if($user instanceof User){
            $data["user"] = $user;
        }
        $response = $apiService->apiGetFruits($data);
        return new JsonResponse($response);
    }
    
    /**
     * @Route("/api/get/users", name="api_get_users")
     */
    public function apiGetUsers(Request $request, APIService $apiService){
        // Respuesta por defecto
        $response = array(
            "status" => false,
            "message" => "Error inesperado, prueba más tarde."
        );
        // Intentamos obtener datos tipo JSON
        $data = json_decode($request->getContent(), true);
        if(!$data){
            // Obtenemos data de form
            $data = $request->request->all();
        }
        $user = $this->getUser();
        if($user instanceof User){
            $data["user"] = $user;
        }
        $response = $apiService->apiGetUsers($data);
        return new JsonResponse($response);
    }

    /**
     * @Route("/api/get/tokens", name="api_get_tokens")
     */
    public function apiGetTokens(Request $request, APIService $apiService){
        // Respuesta por defecto
        $response = array(
            "status" => false,
            "message" => "Error inesperado, prueba más tarde."
        );
        // Intentamos obtener datos tipo JSON
        $data = json_decode($request->getContent(), true);
        if(!$data){
            // Obtenemos data de form
            $data = $request->request->all();
        }
        $user = $this->getUser();
        if($user instanceof User){
            $data["user"] = $user;
        }
        $response = $apiService->apiGetTokens($data);
        return new JsonResponse($response);
    }

    /**
     * @Route("/api/create/token", name="api_create_token")
     */
    public function apiCreateToken(Request $request, APIService $apiService){
        // Respuesta por defecto
        $response = array(
            "status" => false,
            "message" => "Error inesperado, prueba más tarde."
        );
        // Intentamos obtener datos tipo JSON
        $data = json_decode($request->getContent(), true);
        if(!$data){
            // Obtenemos data de form
            $data = $request->request->all();
        }
        $user = $this->getUser();
        if($user instanceof User){
            $data["user"] = $user;
        }
        $response = $apiService->createUserToken($data);
        return new JsonResponse($response);
    }

    /**
     * @Route("/api/check/token", name="api_check_token")
     * Función que comprueba que un token es correcto
     */
    public function apiCheckToken(Request $request, APIService $apiService){
        // Respuesta por defecto
        $response = array(
            "status" => false,
            "message" => "Error inesperado, prueba más tarde."
        );
        // Intentamos obtener datos tipo JSON
        $data = json_decode($request->getContent(), true);
        if(!$data){
            // Obtenemos data de form
            $data = $request->request->all();
        }
        $response = $apiService->checkToken($data);
        return new JsonResponse($response);
    }

    /**
     * @Route("/api/delete/token", name="api_delete_token")
     * Función que borra un token
     */
    public function apiDeleteToken(Request $request, APIService $apiService){
        // Respuesta por defecto
        $response = array(
            "status" => false,
            "message" => "Error inesperado, prueba más tarde."
        );
        // Intentamos obtener datos tipo JSON
        $data = json_decode($request->getContent(), true);
        if(!$data){
            // Obtenemos data de form
            $data = $request->request->all();
        }
        $user = $this->getUser();
        if($user instanceof User){
            $data["user"] = $user;
        }
        $response = $apiService->deleteUserToken($data);
        return new JsonResponse($response);
    }

}