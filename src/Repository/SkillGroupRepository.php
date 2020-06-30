<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\SkillGroup;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SkillGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method SkillGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method SkillGroup[]    findAll()
 * @method SkillGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SkillGroup::class);
    }

    /**
     * @param User $user
     * @return int|mixed|string
     */
    public function findByUser(User $user)
    {
        return $this->createQueryBuilder('sg')
            ->join('sg.skills', 's')
            ->join('s.profiles', 'p')
            ->join('p.user', 'u')
            ->where('u = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}
