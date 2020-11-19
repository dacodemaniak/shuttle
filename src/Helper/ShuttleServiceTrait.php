<?php
namespace App\Helper;

use App\Service\ShuttleService;

trait ShuttleServiceTrait {
    protected $shuttleService;
    
    /**
     * @required
     * @param ShuttleService $service
     */
    public function setShuttleService(ShuttleService $service): void {
        $this->shuttleService = $service;
    }
}

