<?php
namespace App\EventListener;

use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Entity\Booking;

class BookingFinalize
{

    public function __construct()
    {}
    
    public function postPersist(LifecycleEventArgs $args) {
        // Gets Entity
        $entity = $args->getObject();
        
        // Manager
        $manager = $args->getObjectManager();
        
        // Our logic here
        if ($entity instanceof Booking) {
            // Update shuttle status if
            
            // Send an email to customer
        }
    }
}

