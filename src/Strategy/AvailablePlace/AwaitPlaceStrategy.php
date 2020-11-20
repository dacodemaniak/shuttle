<?php
namespace App\Strategy\AvailablePlace;

use App\Strategy\AvailablePlace\AvailablePlaceStrategyInterface;
use Symfony\Component\HttpFoundation\Response;

final class AwaitPlaceStrategy implements AvailablePlaceStrategyInterface
{

    public function send(): Response
    {
        return new Response('Booking is processed, this may take a while');
    }
}

