<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Shuttle;
use App\Form\ReservationType;
use App\Entity\Customer;

use App\Service\BookingFormService;
use App\Service\BookingService;

use App\Service\ResaFormService;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Booking;
use App\Events;
use App\Helper\EntityManagerTrait;
use App\Strategy\AvailablePlace\AvailablePlaceStrategyInterface;
use App\Strategy\AvailablePlace\AvailablePlaceStrategy;
use App\Helper\Factory\AvailableStrategyFactory;
use App\Helper\EventDispatcher\EventDispatcherTrait;
use Symfony\Component\EventDispatcher\GenericEvent;

use Symfony\Component\Messenger\MessageBusInterface;
use App\Message\Booking\BookingEnvelop;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;

class ShuttleController extends AbstractController {
    
    /**
     * Le trait sera utilisé pour accéder directement
     * à l'instance courante de l'EntityManagerInterface
     * instancié par le setter du trait.
     */
    use EntityManagerTrait, EventDispatcherTrait;
    
    private $tours;
    
    /**
     * 
     * @var ResaFormService
     */
    private $formService;
    
    /**
     * 
     * @var AvailablePlaceStrategyInterface
     */
    private $strategy;
    
    public function __construct(ResaFormService $formService) {
        $this->formService = $formService;
        
        $this->strategy = new AvailablePlaceStrategy();
        
        $tour = new Shuttle();
        $tour
            ->setId(1)
            ->setDate(\DateTime::createFromFormat("d-m-Y H:i", "18-11-2020 08:00"));

        $this->tours[] = $tour;
        
        $tour = clone $tour;
        $tour
            
            ->setDate(\DateTime::createFromFormat("d-m-Y H:i", "18-11-2020 11:00"));
        $this->tours[] = $tour;
        
        $tour = clone $tour;
        $tour
            
            ->setDate(\DateTime::createFromFormat("d-m-Y H:i", "18-11-2020 14:00"));
        $this->tours[] = $tour;
        
        $tour = clone $tour;
        $tour
            
            ->setDate(\DateTime::createFromFormat("d-m-Y H:i", "18-11-2020 17:00"));
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
            'formResa' => $this->displayForm(),
             "id" => $id,
            "shuttle" => $tour
        ]);
    }
    
    /**
     * @Route("/shuttle/resa", methods={"GET", "HEAD"}, name="all_resa_day")
     * 
     * @param BookingService $bookingService
     * @return Response
     */
    public function getDayResa(BookingService $bookingService): Response {
        return $this->json(
            $bookingService->getDayResa()
        );
    }
    
    /**
     * @Route("/shuttle/resa/{id}", name="display_resa_form", methods={"GET", "HEAD"})
     * 
     * @return Response
     */

    public function displayForm(): FormInterface {
        return $this->formService->create($this);

    }
    
    /**
     * @Route("/shuttle/resa/{id}", name="process_resa_form", methods={"POST", "HEAD"})
     * 
     * @return Response
     */
    public function processForm(int $id, Request $request, BookingService $bookingService, BookingFormService $builder): Response {
        $customer = new Customer();
        
        $form = $builder->makeForm($customer);
        
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
        
        return $this->redirectToRoute("display_resa_form", ["id" => $id]);
    }
    
    /**
     * @Route("/shuttle/add/booking/{resa}/{customer}", name="add_resa", methods={"GET", "HEAD"})
     * @return Response
     */
    public function poorResa(int $resa, int $customer, MessageBusInterface $bus): Response {
        $theShuttle = $this->em
            ->getRepository(Shuttle::class)
            ->find($resa);
        $before = $theShuttle->getPlaces();
        
        $theCustomer = $this->em
            ->getRepository(Customer::class)
            ->find($customer);
        
        $booking = new Booking();
        $booking
            ->setCustomer($theCustomer)
            ->setShuttle($theShuttle)
            ->setPlaces(1);
        $this->em->persist($booking);
        
        //$this->em->flush();
        
        // Triggering the SHUTTLE_BOOKING event
        //$event = new GenericEvent($booking);
        // Dispatch the event...
        //$this->eventDispatcher->dispatch($event, Events::SHUTTLE_BOOKING);
        
        $stamp = new AmqpStamp('booking');
        $message = new BookingEnvelop($booking);
        
        $bus->dispatch($message, $stamp);
        
        // @todo Get the instance of the correct strategy
        $this->strategy = AvailableStrategyFactory::getStrategy(null);
        return $this->strategy->send();
    }
}
