<?php
namespace App\MessageHandler\Booking;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Message\Booking\BookingEnvelop;
use App\Helper\Logger\LoggerTrait;

class BookingHandler implements MessageHandlerInterface {
    use LoggerTrait;
    public function __invoke(BookingEnvelop $envelop) {
        $this->logger->info(
            'Une nouvelle réservation vient d\'être effectuée, le coût est de ' . $envelop->getBooking()->getPlaces() * 8
        );
    }
}

