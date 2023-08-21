<?php

namespace App\Repository;

use App\Entity\FraisScolaritesAbandon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FraisScolaritesAbandon>
 *
 * @method FraisScolaritesAbandon|null find($id, $lockMode = null, $lockVersion = null)
 * @method FraisScolaritesAbandon|null findOneBy(array $criteria, array $orderBy = null)
 * @method FraisScolaritesAbandon[]    findAll()
 * @method FraisScolaritesAbandon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FraisScolaritesAbandonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FraisScolaritesAbandon::class);
    }

    public function findElevesNonExonoresReintegrer()
    {
        return $this->createQueryBuilder('f')
            ->leftJoin('f.eleve', 'e')
            ->andWhere('e.isActif = :isActif')
            ->andWhere('e.isAdmis = :isAdmis')
            ->setParameter('isActif', true)
            ->setParameter('isAdmis', true)
            ->getQuery()
            ->getResult();
    }

    public function findByEleve($eleve): ?FraisScolaritesAbandon
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.eleve = :val')
            ->setParameter('val', $eleve)
            ->getQuery()
            ->getOneOrNullResult();
    }


    //    /**
    //     * @return FraisScolaritesAbandon[] Returns an array of FraisScolaritesAbandon objects
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

    //    public function findOneBySomeField($value): ?FraisScolaritesAbandon
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
