<?php
namespace App\MessageHandler\Booking;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Message\Booking\BookingEnvelop;
use App\Helper\Logger\LoggerTrait;
use App\Helper\EntityManagerTrait;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Messenger\MessageBusInterface;

class BookingHandler implements MessageHandlerInterface {
    
    use LoggerTrait, EntityManagerTrait;
    
    /**
     * 
     * @var MessageBusInterface
     */
    private $bus;
    
    public function __construct(MessageBusInterface $bus) {
        $this->bus = $bus;
    }
    
    public function __invoke(BookingEnvelop $envelop) {
        $this->logger->info(
            'le coût est de ' . $envelop->getBooking()->getPlaces() * 8 .
            ' Shuttle : ' . $envelop->getBooking()->getShuttle()->getId() .
            ' Customer : ' . $envelop->getBooking()->getCustomer()->getId()
        );
        
        $this->em->persist($envelop->getBooking());
        $this->em->flush();
        
        // Create an update (as an envelop)
        $update = new Update(
            'https://example.com/my-private-topic',
            json_encode([
                'message' => $envelop->getBooking()->getShuttle()->getPlaces()
            ])
         );
        
        // Send the Update in the bus
        $this->bus->dispatch($update);
    }
}

