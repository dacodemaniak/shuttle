<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ShuttleController extends AbstractController
{
    /**
     * @Route("/shuttle", name="shuttle")
     */
    public function index(): Response {
        return $this->render('shuttle/index.html.twig', [
            'title' => 'Shuttle list works!',
        ]);
    }

    /**
     * @Route("/shuttle/{id}", name="shuttle_detail", methods={"GET", "HEAD"}, requirements={"id"="\d+"})
     */
    public function oneShuttle(int $id): Response {
        return $this->render('shuttle/detail.html.twig', [
            'title' => 'Shuttle detail works!',
             "id" => $id
        ]);
    }
}
