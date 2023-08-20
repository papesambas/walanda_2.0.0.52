<?php

namespace App\Repository;

use App\Entity\Departs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Departs>
 *
 * @method Departs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Departs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Departs[]    findAll()
 * @method Departs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepartsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Departs::class);
    }

//    /**
//     * @return Departs[] Returns an array of Departs objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Departs
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
