<?php

namespace App\Repository;

use App\Entity\Classes;
use Doctrine\ORM\Query;
use App\Entity\FraisScolarites;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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

    public function findByEleve($eleve): ?FraisScolarites
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.eleve = :val')
            ->setParameter('val', $eleve)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function save(FraisScolarites $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FraisScolarites $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findForPagination(?Classes $classes): Query
    {
        $qb = $this->createQueryBuilder('f')
            ->leftJoin('f.eleve', 'e')
            ->orderBy('e.fullname', 'ASC');

        if ($classes) {
            $qb->leftJoin('e.classe', 'c')
                ->OrderBy('c.designation', 'ASC')
                ->andWhere('c.id = :classeId')
                ->setParameter('classeId', $classes->getId());
        }
        return $qb->getQuery();
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
