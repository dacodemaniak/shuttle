<?php
namespace App\Strategy\AvailablePlace;

use Symfony\Component\HttpFoundation\Response;

interface AvailablePlaceStrategyInterface {
    public function send(): Response;
}

