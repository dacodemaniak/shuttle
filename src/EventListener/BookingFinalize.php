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
            // Decrease available places
            
            $shuttle = $entity->getShuttle();
            $shuttle->setPlaces($shuttle->getPlaces() - $entity->getPlaces());
            
            $manager->persist($shuttle);
            
            $manager->flush();
            
            // If ever, set status as complete
            
            // Process all other logic here
        }
    }
}

