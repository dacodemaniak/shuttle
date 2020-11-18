<?php
namespace App\Helper;

use Doctrine\ORM\EntityManagerInterface;

trait EntityManagerTrait {
    /**
     * 
     * @var EntityManagerInterface
     */
    protected $em;
    
    /**
     * @required
     * 
     * @param EntityManagerInterface $entityManager
     */
    public function setEntityManager(EntityManagerInterface $entityManager): void {
        $this->em = $entityManager;
    }
    
}

