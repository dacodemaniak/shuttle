<?php
namespace App\Service;


use App\Entity\Shuttle;
use App\Helper\EntityManagerTrait;

class ShuttleService {
    use EntityManagerTrait;
    
    public function getShuttle(int $id): ?Shuttle {
       return $this->em->getRepository(Shuttle::class)->find($id); 
    }
}

