<?php
namespace App\Helper\Factory;

use App\Strategy\AvailablePlace\AvailablePlaceStrategyInterface;
use App\Strategy\AvailablePlace\UnAvailablePlaceStrategy;
use App\Strategy\AvailablePlace\AvailablePlaceStrategy;
use App\Entity\Shuttle;
use App\Strategy\AvailablePlace\AwaitPlaceStrategy;
use App\Entity\Booking;

abstract class AvailableStrategyFactory
{
    public static function getStrategy($entityObject): AvailablePlaceStrategyInterface {
        if ($entityObject instanceof Booking) {
            return new AwaitPlaceStrategy();
        }
        if ($entityObject->getPlaces() > 0) {
            return new AvailablePlaceStrategy();
        }
        
        return new UnAvailablePlaceStrategy();
    }
}

