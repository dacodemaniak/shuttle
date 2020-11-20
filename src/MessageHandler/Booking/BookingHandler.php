<?php
namespace App\MessageHandler\Booking;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Message\Booking\BookingEnvelop;
use App\Helper\Logger\LoggerTrait;
use App\Helper\EntityManagerTrait;

class BookingHandler implements MessageHandlerInterface {
    
    use LoggerTrait, EntityManagerTrait;
    
    public function __invoke(BookingEnvelop $envelop) {
        $this->logger->info(
            'le coût est de ' . $envelop->getBooking()->getPlaces() * 8 .
            ' Shuttle : ' . $envelop->getBooking()->getShuttle()->getId() .
            ' Customer : ' . $envelop->getBooking()->getCustomer()->getId()
        );
        
        $this->em->persist($envelop->getBooking());
        $this->em->flush();
    }
}

