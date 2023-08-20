<?php

namespace App\Repository;

use App\Entity\Santes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Santes>
 *
 * @method Santes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Santes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Santes[]    findAll()
 * @method Santes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SantesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Santes::class);
    }

//    /**
//     * @return Santes[] Returns an array of Santes objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Santes
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
