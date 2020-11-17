<?php

namespace App\Controller;

use App\Entity\Shuttle;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/api", name="_api")
 * @author jlaubert
 *
 */
class ApiShuttleController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/shuttle", name="api_shuttle")
     * @Rest\View(
     *  statusCode = 201
     * )
     */
    public function index(): Response {
        $repository = $this->getDoctrine()->getRepository(Shuttle::class);
        
        $shuttles = $repository->findAll();
        
        return $this->handleView($this->view($shuttles));
    }
    
    /**
     * @Rest\Post("/shuttle", name="api_post_shuttle")
     * @View(statusCode=201)
     * @ParamConverter("shuttle", converter="fos_rest.request_body")
     * 
     * @param Shuttle $shuttle
     * @return Shuttle
     */
    public function create(Shuttle $shuttle) {
        $entityManager = $this->getDoctrine()->getManager();
        
        $entityManager->persist($shuttle);
        
        $entityManager->flush();
        
        
        return $this->view($shuttle);
    }
    
    /**
     * @Rest\Patch("/shuttle", name="api_patch_shuttle")
     * @View(statusCode=200)
     * @ParamConverter("shuttle", converter="fos_rest.request_body")
     * 
     * @param Shuttle $shuttle
     * @return Response
     */
    public function updateShuttlePlaces(Shuttle $shuttle) {
        
        if ($shuttle instanceof Shuttle) {
            
            $entityManager = $this->getDoctrine()->getManager();
            
            $data = $this->getDoctrine()->getManager()->find(Shuttle::class, $shuttle->getId());
            $data->setPlaces($shuttle->getPlaces());
            
            $entityManager->persist($data);
            
            $entityManager->flush();
            
            return $this->view($shuttle);
        }
        
        return $this->view("Not found!", Response::HTTP_FOUND);
        
    }
}
