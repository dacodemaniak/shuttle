<?php
namespace App\Helper\Factory;

use App\Strategy\AvailablePlace\AvailablePlaceStrategyInterface;
use App\Strategy\AvailablePlace\UnAvailablePlaceStrategy;
use App\Strategy\AvailablePlace\AvailablePlaceStrategy;
use App\Entity\Shuttle;

abstract class AvailableStrategyFactory
{
    public static function getStrategy(Shuttle $shuttle): AvailablePlaceStrategyInterface {
        if ($shuttle->getPlaces() > 0) {
            return new AvailablePlaceStrategy();
        }
        
        return new UnAvailablePlaceStrategy();
    }
}

