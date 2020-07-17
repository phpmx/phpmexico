<?php

namespace App\Repository;

use App\Entity\MeetupEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MeetupEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method MeetupEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method MeetupEvent[]    findAll()
 * @method MeetupEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MeetupEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MeetupEvent::class);
    }

    // /**
    //  * @return MeetupEvent[] Returns an array of MeetupEvent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MeetupEvent
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
