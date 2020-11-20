<?php
namespace App\Helper\Factory;

use App\Strategy\AvailablePlace\AvailablePlaceStrategyInterface;
use App\Strategy\AvailablePlace\UnAvailablePlaceStrategy;
use App\Strategy\AvailablePlace\AvailablePlaceStrategy;
use App\Entity\Shuttle;
use App\Strategy\AvailablePlace\AwaitPlaceStrategy;

abstract class AvailableStrategyFactory
{
    public static function getStrategy(Shuttle $shuttle = null): AvailablePlaceStrategyInterface {
        if ($shuttle === null) {
            return new AwaitPlaceStrategy();
        }
        if ($shuttle->getPlaces() > 0) {
            return new AvailablePlaceStrategy();
        }
        
        return new UnAvailablePlaceStrategy();
    }
}

