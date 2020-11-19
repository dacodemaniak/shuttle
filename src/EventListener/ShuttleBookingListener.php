<?php
namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use App\Events;
use Symfony\Component\HttpKernel\Log\Logger;
use Psr\Log\LoggerInterface;

class ShuttleBookingListener implements EventSubscriberInterface {
    /**
     * Emitter of the notification
     * @var string
     */
    private $emitter;
    
    /**
     * Logger
     * @var LoggerInterface
     */
    private $logger;
    
    public function __construct(LoggerInterface $logger, string $emitter) {
        $this->emitter = $emitter;
        $this->logger = $logger;
    }
    
    public static function getSubscribedEvents(): array {
        return [
            Events::SHUTTLE_BOOKING => 'onShuttleBooking'
        ];
    }
    
    /**
     * Method triggered when the Event will be fired
     * @param GenericEvent Generic event fired
     */
    public function onShuttleBooking(GenericEvent $event): void {
        // Get the Subject
        $booking = $event->getSubject();
        
        dd($this->emitter . ' send a new Booking ' . $booking->getShuttle()->getPlaces() . ' remaining');
        
        $this->logger->info($this->emitter . ' send a new Booking');
        
    }
}

