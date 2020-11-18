<?php
namespace App\Helper\Factory;

use App\Strategy\AvailablePlace\AvailablePlaceStrategyInterface;
use App\Strategy\AvailablePlace\UnAvailablePlaceStrategy;
use App\Strategy\AvailablePlace\AvailablePlaceStrategy;

abstract class AvailableStrategyFactory
{
    public static function getStrategy(int $availablePlace): AvailablePlaceStrategyInterface {
        if ($availablePlace > 0) {
            return new AvailablePlaceStrategy();
        }
        
        return new UnAvailablePlaceStrategy();
    }
}

