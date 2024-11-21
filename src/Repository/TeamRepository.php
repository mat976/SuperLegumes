<?php

namespace App\Repository;

use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Team>
 *
 * @method Team|null find($id, $lockMode = null, $lockVersion = null)
 * @method Team|null findOneBy(array $criteria, array $orderBy = null)
 * @method Team[]    findAll()
 * @method Team[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Team::class);
    }

    public function findActiveTeams()
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.isActive = :val')
            ->setParameter('val', true)
            ->orderBy('t.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findTeamsWithoutCurrentMission()
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.currentMission IS NULL')
            ->orderBy('t.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
