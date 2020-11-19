<?php
namespace App\Helper;

use App\Service\CustomerService;

trait CustomerServiceTrait {
    protected $customerService;
    
    /**
     * @required
     * @param CustomerService $service
     */
    public function setCustomerService(CustomerService $service): void {
        $this->customerService = $service;
    }
}

