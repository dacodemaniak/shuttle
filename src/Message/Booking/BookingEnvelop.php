<?php
namespace App\Message\Booking;

use App\Entity\Booking;

class BookingEnvelop {
    /**
     * 
     * @var App\Entity\Booking
     */
    private $booking;
    
    public function __construct(Booking $booking) {
        $this->booking = $booking;
    }
    
    public function getBooking(): Booking {
        return $this->booking;
    }
}

