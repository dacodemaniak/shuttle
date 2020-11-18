<?php
namespace App\Strategy\AvailablePlace;

use App\Strategy\AvailablePlace\AvailablePlaceStrategyInterface;
use Symfony\Component\HttpFoundation\Response;

final class AvailablePlaceStrategy implements AvailablePlaceStrategyInterface
{

    public function send(): Response
    {
        return new Response('Okay, on peut continuer');
    }
}

