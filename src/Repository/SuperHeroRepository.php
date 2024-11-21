<?php

namespace App\Repository;

use App\Entity\SuperHero;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SuperHero>
 *
 * @method SuperHero|null find($id, $lockMode = null, $lockVersion = null)
 * @method SuperHero|null findOneBy(array $criteria, array $orderBy = null)
 * @method SuperHero[]    findAll()
 * @method SuperHero[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuperHeroRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SuperHero::class);
    }

    public function findAvailableHeroes()
    {
        return $this->createQueryBuilder('sh')
            ->andWhere('sh.isAvailable = :val')
            ->setParameter('val', true)
            ->orderBy('sh.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findHeroesByEnergyLevelRange($min, $max)
    {
        return $this->createQueryBuilder('sh')
            ->andWhere('sh.energyLevel >= :min')
            ->andWhere('sh.energyLevel <= :max')
            ->setParameter('min', $min)
            ->setParameter('max', $max)
            ->orderBy('sh.energyLevel', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
