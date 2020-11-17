<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Customer;
use App\Entity\Shuttle;
use App\Entity\Booking;

use App\DataFixtures\RandomHelper;

use Faker;

class AppFixtures extends Fixture
{
    /**
     * 
     * @var <Customer>[]
     */
    private $_customers;
    
    /**
     * 
     * @var <Shuttle>[]
     */
    private $_shuttles;
    
    /**
     * 
     * @var <Booking>[]
     */
    private $_bookings;
    
    /**
     * 
     * @var Faker
     */
    private $faker;
    
    /**
     * Store Customer for Shuttle
     * @var array
     */
    private $customerToShuttle;
    /**
     * 
     * @var ObjectManager
     */
    private $manager;
    
    public function load(ObjectManager $manager)
    {
           $this->faker = Faker\Factory::create('fr-FR');
           $this->manager = $manager;
           $this->customerToShuttle = [];
           
           $this->_fakeCustomers();
           $this->_fakeShuttles();
           $this->_fakeBookings();
           
           // Persistence for shuttle and bookings
           foreach ($this->_bookings as $booking) {
               $manager->persist($booking->getShuttle());
               $manager->persist($booking);
           }
        // $product = new Product();
        // $manager->persist($product);

        $this->manager->flush();
    }
    
    private function _fakeCustomers(): void {
        // Create some instances of Customers
        $this->_customers = [];
        
        for ($i=0; $i < 10; $i++) {
            $customer = new Customer();
            $customer
                ->setLastName($this->faker->lastName)
                ->setFirstName($this->faker->firstName)
                ->setWishedPlaces(1)
                ->setEmail($this->faker->email);
            $this->_customers[] = $customer;
            $this->manager->persist($customer);
            
        }
    }
    
    private function _fakeShuttles(): void {
        // Create some instances of Shuttle
        $this->_shuttles = [];
        
        for ($i=0; $i < 20; $i++) {
            $shuttle = new Shuttle();
            $shuttle
                ->setDate($this->faker->dateTimeBetween('-30 days', 'now', 'Europe/Paris'));
            $this->_shuttles[] = $shuttle;
        }
    }
    
    private function _fakeBookings(): void {
        // Create some instances of Booking
        $this->_bookings = [];
        
        for ($i=0; $i < 10; $i++) {
            $shuttleId = RandomHelper::getRandomInteger(0, 19);
            $customerId = RandomHelper::getRandomInteger(0, 9);
            
            $customerId = $this->_checkCustomerToShuttle($shuttleId, $customerId);
            
            $booking = new Booking();
            $booking
                ->setShuttle($this->_shuttles[$shuttleId])
                ->setCustomer($this->_customers[$customerId])
                ->setPlaces($this->faker->numberBetween(1, 3));
            $this->_shuttles[$shuttleId]->addBooking($booking);
            $this->_bookings[] = $booking;
        }
    }
    
    private function _checkCustomerToShuttle($shuttleId, $customerId): int {
        if (count($this->customerToShuttle)) {
            foreach ($this->customerToShuttle as $customerToShuttle) {
                if ($customerToShuttle[0] === $shuttleId && $customerToShuttle[1] === $customerId) {
                    $customerId = RandomHelper::getRandomInteger(0, 9);
                    // Replay check
                    $this->_checkCustomerToShuttle($shuttleId, $customerId);
                }
            }
        }
        
        return $customerId;
    }
}
