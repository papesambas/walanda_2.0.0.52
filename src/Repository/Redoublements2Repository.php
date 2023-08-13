<?php

namespace App\Repository;

use App\Entity\Redoublements2;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Redoublements2>
 *
 * @method Redoublements2|null find($id, $lockMode = null, $lockVersion = null)
 * @method Redoublements2|null findOneBy(array $criteria, array $orderBy = null)
 * @method Redoublements2[]    findAll()
 * @method Redoublements2[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Redoublements2Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Redoublements2::class);
    }

//    /**
//     * @return Redoublements2[] Returns an array of Redoublements2 objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Redoublements2
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
