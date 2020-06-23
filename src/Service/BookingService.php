<?php
namespace App\Service;

use App\Entity\Customer;
use App\Entity\Shuttle;
use App\Entity\Booking;
use Doctrine\ORM\EntityManagerInterface;

class BookingService
{
    private $customer;
    private $shuttle;
    
    private $em;
    
    public function __construct(EntityManagerInterface $manager){
        $this->em = $manager;
    }
    
    public function setCustomer(Customer $customer): self {
        $this->customer = $customer;
        
        $this->em->persist($this->customer);
        
        return $this;
    }
    
    public function setShuttle(Shuttle $shuttle): self {
        $this->shuttle = $shuttle;
        
        $this->em->persist($this->shuttle);
        
        return $this;
    }
    
    public function persist(): void {
        $booking = new Booking();
        
        $booking
            ->setCustomer($this->customer)
            ->setShuttle($this->shuttle)
            ->setPlaces($this->customer->getWishedPlaces());
        
            $this->em->persist($booking);
            
            // Finalize transaction
            $this->em->flush();
    }
    
    public function getDayResa(): array  {
        $repo = $this->em->getRepository(Booking::class);
        
        return $repo->findByDate(\DateTime::createFromFormat("d-m-Y", "22-06-2020"));
    }
}

