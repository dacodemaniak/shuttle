<?php
namespace App\Strategy\AvailablePlace;

use App\Strategy\AvailablePlace\AvailablePlaceStrategyInterface;
use Symfony\Component\HttpFoundation\Response;

final class UnAvailablePlaceStrategy implements AvailablePlaceStrategyInterface
{

    public function send($entityObject): Response
    {
        return new Response('On a plus de place désolé');
    }
}

