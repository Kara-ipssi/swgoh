<?php

namespace App\Repository;

use App\Entity\Guilds;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Guilds>
 *
 * @method Guilds|null find($id, $lockMode = null, $lockVersion = null)
 * @method Guilds|null findOneBy(array $criteria, array $orderBy = null)
 * @method Guilds[]    findAll()
 * @method Guilds[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GuildsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Guilds::class);
    }

//    /**
//     * @return Guilds[] Returns an array of Guilds objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Guilds
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
