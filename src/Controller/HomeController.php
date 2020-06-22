<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request): Response {
        // You logic here...
        $ip = $request->getClientIp();
        
        return $this->render(
            "home/index.html.twig"
        );
    }
    
    /**
     * @Route("/home/shuttle/{id}", name="one_shuttle", methods={"GET", "HEAD"}, requirements={"id"="\d+"})
     * @return Response
     */
    public function oneShuttle(Request $request, int $id): Response {
        $query = $request->query->get("user", "Jean-Luc"); // $_GET
        
        return $this->render(
            "home/index.html.twig",
            [
                "id" => $id,
                "user" => $query
            ]
        );
    }
}
