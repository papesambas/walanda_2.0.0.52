<?php

namespace App\Repository;

use App\Entity\Niveaux;
use App\Entity\Statuts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Statuts>
 *
 * @method Statuts|null find($id, $lockMode = null, $lockVersion = null)
 * @method Statuts|null findOneBy(array $criteria, array $orderBy = null)
 * @method Statuts[]    findAll()
 * @method Statuts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatutsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Statuts::class);
    }

    public function findStatutsForNlEnregistrement(?Niveaux $niveaux = null): array
    {
        return $this->createQueryBuilder('s')
            ->where('s.designation = :inscription OR s.designation = :transfert')
            ->andWhere('s.niveau = :niveauId') // Utilisez = ici au lieu de :
            ->setParameter('inscription', '1ère Inscription')
            ->setParameter('transfert', 'Transfert Arrivé')
            ->setParameter('niveauId', $niveaux ? $niveaux->getId() : [])
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Statuts[] Returns an array of Statuts objects
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

    //    public function findOneBySomeField($value): ?Statuts
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}