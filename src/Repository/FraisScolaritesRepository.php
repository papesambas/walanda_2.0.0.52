<?php

namespace App\Repository;

use App\Entity\FraisScolarites;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FraisScolarites>
 *
 * @method FraisScolarites|null find($id, $lockMode = null, $lockVersion = null)
 * @method FraisScolarites|null findOneBy(array $criteria, array $orderBy = null)
 * @method FraisScolarites[]    findAll()
 * @method FraisScolarites[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FraisScolaritesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FraisScolarites::class);
    }

//    /**
//     * @return FraisScolarites[] Returns an array of FraisScolarites objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FraisScolarites
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
