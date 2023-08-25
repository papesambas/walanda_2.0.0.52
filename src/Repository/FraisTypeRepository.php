<?php

namespace App\Repository;

use App\Entity\FraisType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FraisType>
 *
 * @method FraisType|null find($id, $lockMode = null, $lockVersion = null)
 * @method FraisType|null findOneBy(array $criteria, array $orderBy = null)
 * @method FraisType[]    findAll()
 * @method FraisType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FraisTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FraisType::class);
    }

    public function findByNiveauAndStatut($niveau, $statut): ?FraisType
    {
        return $this->createQueryBuilder('f')
            ->where('f.niveau = :niveau')
            ->andWhere('f.statut = :statut')
            ->setParameter('niveau', $niveau)
            ->setParameter('statut', $statut)
            ->orderBy('f.id', 'ASC')
            ->getQuery()
            ->getOneOrNullResult();
    }


    //    /**
    //     * @return FraisType[] Returns an array of FraisType objects
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

    //    public function findOneBySomeField($value): ?FraisType
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}