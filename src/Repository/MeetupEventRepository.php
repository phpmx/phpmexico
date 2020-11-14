<?php

namespace App\Repository;

use App\Entity\MeetupEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
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

    public function getAllQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('me');
    }
}
