<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Mercure\Publisher;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;
use App\Entity\Customer;
use App\Entity\Shuttle;
use App\Entity\Booking;
use App\Helper\EntityManagerTrait;
use App\Message\Booking\BookingEnvelop;
use Symfony\Component\Messenger\Transport\AmqpExt\AmqpStamp;

class PublishController extends AbstractController
{
    use EntityManagerTrait;
    /**
     * @Route("/message", name="publishMessage")
     */
    public function index(MessageBusInterface $bus, Request $request)
    {
        // Send a new resa call
        $newResa = json_decode($request->getContent());
        
        $theShuttle = $this->em
            ->getRepository(Shuttle::class)
            ->find($newResa->resa);
        $before = $theShuttle->getPlaces();
        
        $theCustomer = $this->em
            ->getRepository(Customer::class)
            ->find($newResa->customer);
        
        $booking = new Booking();
        $booking
            ->setCustomer($theCustomer)
            ->setShuttle($theShuttle)
            ->setPlaces($newResa->places);
        
        $stamp = new AmqpStamp(
              'booking'
                );
        $message = new BookingEnvelop($booking);
            
        $bus->dispatch($message, [$stamp]);
        
        //$publisher($update);
        
        //return $this->redirectToRoute('home');

    }
}
