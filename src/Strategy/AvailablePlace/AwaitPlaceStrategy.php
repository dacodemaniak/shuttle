<?php
namespace App\Strategy\AvailablePlace;

use App\Strategy\AvailablePlace\AvailablePlaceStrategyInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Booking;

final class AwaitPlaceStrategy implements AvailablePlaceStrategyInterface
{

    public function send($entityObject): Response
    {
        return new Response('Booking is processed for ' . $entityObject->getPlaces() . ', this may take a while');
    }
}

