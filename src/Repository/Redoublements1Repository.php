<?php

namespace App\Repository;

use App\Entity\Redoublements1;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Redoublements1>
 *
 * @method Redoublements1|null find($id, $lockMode = null, $lockVersion = null)
 * @method Redoublements1|null findOneBy(array $criteria, array $orderBy = null)
 * @method Redoublements1[]    findAll()
 * @method Redoublements1[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Redoublements1Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Redoublements1::class);
    }

    public function findByScolarites1AndScolarites2($scolarite1, $scolarite2)
    {
        return $this->createQueryBuilder('r')
            ->Where('r.scolarite1 = :scolarite1')
            //->setParameter('scolarite1', $scolarite1)
            ->andWhere('r.scolarite2 = :scolarite2')
            //->setParameter('scolarite2', $scolarite2)
            ->setParameters(['scolarite1' => $scolarite1, 'scolarite2' => $scolarite2])
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Redoublements1[] Returns an array of Redoublements1 objects
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

    //    public function findOneBySomeField($value): ?Redoublements1
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}