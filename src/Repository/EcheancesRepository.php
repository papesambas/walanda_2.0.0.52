<?php

namespace App\Repository;

use App\Entity\Echeances;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Echeances>
 *
 * @method Echeances|null find($id, $lockMode = null, $lockVersion = null)
 * @method Echeances|null findOneBy(array $criteria, array $orderBy = null)
 * @method Echeances[]    findAll()
 * @method Echeances[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EcheancesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Echeances::class);
    }

//    /**
//     * @return Echeances[] Returns an array of Echeances objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Echeances
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
