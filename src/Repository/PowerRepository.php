<?php

namespace App\Repository;

use App\Entity\Power;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Power>
 *
 * @method Power|null find($id, $lockMode = null, $lockVersion = null)
 * @method Power|null findOneBy(array $criteria, array $orderBy = null)
 * @method Power[]    findAll()
 * @method Power[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PowerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Power::class);
    }

    public function findPowersByLevel($level)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.level = :level')
            ->setParameter('level', $level)
            ->orderBy('p.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
