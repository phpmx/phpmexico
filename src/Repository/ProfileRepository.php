<?php

namespace App\Repository;

use App\Entity\Profile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Profile|null find($id, $lockMode = null, $lockVersion = null)
 * @method Profile|null findOneBy(array $criteria, array $orderBy = null)
 * @method Profile[]    findAll()
 * @method Profile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfileRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Profile::class);
    }

    public function findBySkill($skill)
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->leftJoin('p.skills', 's')
            ->where('s = :skill')
            ->setMaxResults(10)
            ->setParameter('skill', $skill)
            ->setCacheable(true)
            ->setLifetime(86400)
            ->getQuery()
            ->getResult();
    }
}
