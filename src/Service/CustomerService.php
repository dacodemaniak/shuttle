<?php
namespace App\Service;

use App\Helper\EntityManagerTrait;
use App\Entity\Customer;

class CustomerService {
    use EntityManagerTrait;
    
    /**
     * 
     * @param int $id
     * @return Customer|NULL
     */
    public function get(int $id): ?Customer {
        return $this->em->getRepository(Customer::class)->find($id);
    }
}

