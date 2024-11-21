<?php

namespace App\Repository;

use App\Entity\Mission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Mission>
 *
 * @method Mission|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mission|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mission[]    findAll()
 * @method Mission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mission::class);
    }

    public function findActiveMissions()
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.status = :status')
            ->setParameter('status', 'active')
            ->orderBy('m.startAt', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findMissionsByDangerLevel($level)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.dangerLevel = :level')
            ->setParameter('level', $level)
            ->orderBy('m.startAt', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
