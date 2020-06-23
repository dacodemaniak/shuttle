<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Shuttle;
use App\Form\ReservationType;
use App\Entity\Customer;
use App\Service\BookingService;

class ShuttleController extends AbstractController {
    
    private $tours;
    
    
    public function __construct() {
        $tour = new Shuttle();
        $tour
            ->setId(1)
            ->setDate(\DateTime::createFromFormat("d-m-Y H:i", "22-06-2020 08:00"));

        $this->tours[] = $tour;
        
        $tour = clone $tour;
        $tour
            
            ->setDate(\DateTime::createFromFormat("d-m-Y H:i", "22-06-2020 11:00"));
        $this->tours[] = $tour;
        
        $tour = clone $tour;
        $tour
            
            ->setDate(\DateTime::createFromFormat("d-m-Y H:i", "22-06-2020 14:00"));
        $this->tours[] = $tour;
        
        $tour = clone $tour;
        $tour
            
            ->setDate(\DateTime::createFromFormat("d-m-Y H:i", "22-06-2020 17:00"));
        $this->tours[] = $tour;
    }
    
    /**
     * @Route("/shuttle", name="shuttle")
     */
    public function index(): Response {
        return $this->render('shuttle/index.html.twig', [
            'title' => 'Shuttle list',
            "tours" => $this->tours
        ]);
    }

    /**
     * @Route("/shuttle/{id}", name="shuttle_detail", methods={"GET", "HEAD"}, requirements={"id"="\d+"})
     */
    public function oneShuttle(int $id): Response {
        $tour = null;
        foreach ($this->tours as $shuttle) {
            if ($shuttle->getId() === $id) {
                $tour = $shuttle;
            }
        }
        
        return $this->render('shuttle/detail.html.twig', [
            'title' => 'Shuttle detail works!',
             "id" => $id,
            "shuttle" => $tour
        ]);
    }
    
    /**
     * @Route("/shuttle/resa/{id}", name="display_resa_form", methods={"GET", "HEAD"})
     * 
     * @return Response
     */
    public function displayForm(int $id = null, Customer $customer = null): Response {
        $form = $this->createForm(ReservationType::class);
        
        return $this->render(
            "shuttle/form.html.twig",
            [
                "formResa" => $form->createView(),
                "id" => $id,
                "customer" => $customer
            ]
        );
    }
    
    /**
     * @Route("/shuttle/resa/{id}", name="process_resa_form", methods={"POST", "HEAD"})
     * 
     * @return Response
     */
    public function processForm(int $id, Request $request, BookingService $bookingService): Response {
        $customer = new Customer();
        
        $form = $this->createForm(ReservationType::class, $customer);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $bookingService->setCustomer($customer);
            
            $shuttle = null;
            $index = 0;
            $tourIndex = 0;
            foreach ($this->tours as $tour) {
                if ($tour->getId() === $id) {
                    $shuttle = $tour;
                    $tourIndex = $index;
                }
                $index++;
            }
            $bookingService->setShuttle($shuttle);
            
            $bookingService->persist();
            
            // Update places for the shuttle
            $shuttle->setPlaces($shuttle->getPlaces() - $customer->getWishedPlaces());
            $this->tours[$tourIndex] = $shuttle;
        }
        
        return $this->displayForm($id, $customer);
    }
}
