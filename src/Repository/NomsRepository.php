<?php

namespace App\Repository;

use App\Entity\Noms;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Noms>
 *
 * @method Noms|null find($id, $lockMode = null, $lockVersion = null)
 * @method Noms|null findOneBy(array $criteria, array $orderBy = null)
 * @method Noms[]    findAll()
 * @method Noms[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NomsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Noms::class);
    }

//    /**
//     * @return Noms[] Returns an array of Noms objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Noms
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
