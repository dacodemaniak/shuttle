<?php

namespace App\Repository;

use App\Entity\Booking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    private $manager;
    
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Booking::class);
        $this->manager = $manager;
    }

    /**
     * @return Booking[] Returns an array of Booking objects
    */
    public function findByDate(\DateTime $date): array
    {   
        $beginAt = clone $date
            ->setTime("00", "00");
        $endAt = clone $beginAt;
        $endAt->setTime("23", "59");
        
        $query = $this->manager->createQuery(
            'SELECT b.places FROM \App\Entity\Booking b join b.shuttle s WHERE s.date BETWEEN :beginAt AND :endAt'
        );
        
        echo $query->getSQL();
        
        var_dump(
            [
                "beginAt" => $beginAt->format("Y-m-d H:i"),
                "endAt" => $endAt->format("Y-m-d H:i")
            ]
        );
        
        return $query->execute(
            [
                "beginAt" => $beginAt->format("Y-m-d H:i"),
                "endAt" => $endAt->format("Y-m-d H:i")
            ]
        );
        

        
        return $this->createQueryBuilder('b')
            ->join('b.shuttle', 's')
            ->andWhere('s.date = :date')
            ->setParameter('date', $date)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
        
            // SELECT b.*, s.* FROM booking b JOIN shuttle s ON b.shuttle_id = s.id
            // WHERE s.date = '2020-06-22' ORDER BY b.id LIMIT 0, 10
    }

    /*
    public function findOneBySomeField($value): ?Booking
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
