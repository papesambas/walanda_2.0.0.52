<?php

namespace App\Repository;

use App\Entity\FraisScolaires;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FraisScolaires>
 *
 * @method FraisScolaires|null find($id, $lockMode = null, $lockVersion = null)
 * @method FraisScolaires|null findOneBy(array $criteria, array $orderBy = null)
 * @method FraisScolaires[]    findAll()
 * @method FraisScolaires[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FraisScolairesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FraisScolaires::class);
    }

    public function findOneFraisScolariteByNiveauAndStatut($niveau, $statut): ?FraisScolaires
    {
        $qb = $this->createQueryBuilder('f')
            ->andWhere('f.niveau = :niveau')
            ->andWhere('f.statut = :statut')
            ->setParameter('niveau', $niveau)
            ->setParameter('statut', $statut)
            ->getQuery();

        return $qb->getOneOrNullResult();
    }




    //    /**
    //     * @return FraisScolaires[] Returns an array of FraisScolaires objects
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

    //    public function findOneBySomeField($value): ?FraisScolaires
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
