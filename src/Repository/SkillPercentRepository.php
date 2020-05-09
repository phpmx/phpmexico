<?php

namespace App\Repository;

use App\Entity\SkillPercent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SkillPercent|null find($id, $lockMode = null, $lockVersion = null)
 * @method SkillPercent|null findOneBy(array $criteria, array $orderBy = null)
 * @method SkillPercent[]    findAll()
 * @method SkillPercent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillPercentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SkillPercent::class);
    }

    // /**
    //  * @return SkillPercent[] Returns an array of SkillPercent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SkillPercent
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
