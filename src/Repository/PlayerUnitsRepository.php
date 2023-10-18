<?php

namespace App\Repository;

use App\Entity\PlayerUnits;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PlayerUnits>
 *
 * @method PlayerUnits|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlayerUnits|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlayerUnits[]    findAll()
 * @method PlayerUnits[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerUnitsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlayerUnits::class);
    }

//    /**
//     * @return PlayerUnits[] Returns an array of PlayerUnits objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PlayerUnits
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
