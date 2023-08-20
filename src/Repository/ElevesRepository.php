<?php

namespace App\Repository;

use App\Entity\Eleves;
use App\Entity\Classes;
use App\Entity\Departements;
use App\Entity\EcoleProvenances;
use App\Entity\LieuNaissances;
use App\Entity\Statuts;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Eleves>
 *
 * @method Eleves|null find($id, $lockMode = null, $lockVersion = null)
 * @method Eleves|null findOneBy(array $criteria, array $orderBy = null)
 * @method Eleves[]    findAll()
 * @method Eleves[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ElevesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Eleves::class);
    }

    public function findForPagination(?Classes $classes): Query
    {
        $qb = $this->createQueryBuilder('e')
            ->where('e.isActif = :isActif')
            ->orderBy('e.fullname', 'ASC')
            ->addOrderBy('e.dateInscription', 'ASC')
            ->setParameter('isActif', true);

        if ($classes) {
            $qb->leftJoin('e.classe', 'c')
                ->andWhere('c.id = :classeId')
                ->setParameter('classeId', $classes->getId());
        }
        return $qb->getQuery();
    }

    public function findForPaginationStatut(?Statuts $statuts): Query
    {
        $qb = $this->createQueryBuilder('e')
            ->where('e.isActif = :isActif')
            ->orderBy('e.fullname', 'ASC')
            ->addOrderBy('e.dateInscription', 'ASC')
            ->setParameter('isActif', true);

        if ($statuts) {
            $qb->leftJoin('e.statut', 's')
                ->andWhere('s.id = :statutId')
                ->setParameter('statutId', $statuts->getId());
        }
        return $qb->getQuery();
    }

    public function findForPaginationDepartement(?Departements $departements): Query
    {
        $qb = $this->createQueryBuilder('e')
            ->where('e.isActif = :isActif')
            ->orderBy('e.fullname', 'ASC')
            ->addOrderBy('e.dateInscription', 'ASC')
            ->setParameter('isActif', true);

        if ($departements) {
            $qb->leftJoin('e.departement', 'd')
                ->andWhere('d.id = :departementsId')
                ->setParameter('departementsId', $departements->getId());
        }
        return $qb->getQuery();
    }

    public function findForPaginationLieuNaissance(?LieuNaissances $lieuNaissances): Query
    {
        $qb = $this->createQueryBuilder('e')
            ->where('e.isActif = :isActif')
            ->orderBy('e.fullname', 'ASC')
            ->addOrderBy('e.dateInscription', 'ASC')
            ->setParameter('isActif', true);

        if ($lieuNaissances) {
            $qb->leftJoin('e.lieuNaissance', 'l')
                ->andWhere('l.id = :lieuNaissancesId')
                ->setParameter('lieuNaissancesId', $lieuNaissances->getId());
        }
        return $qb->getQuery();
    }

    public function findForPaginationRecrutement(?EcoleProvenances $ecoleProvenances): Query
    {
        $qb = $this->createQueryBuilder('e')
            ->where('e.isActif = :isActif')
            ->orderBy('e.fullname', 'ASC')
            ->addOrderBy('e.dateInscription', 'ASC')
            ->setParameter('isActif', true);

        if ($ecoleProvenances) {
            $qb->leftJoin('e.ecoleRecrutement', 'ecoleRecrutement')
                ->andWhere('ecoleRecrutement.id = :ecoleRecrutementId')
                ->setParameter('ecoleRecrutementId', $ecoleProvenances->getId());
        }
        return $qb->getQuery();
    }

    public function findForPaginationAnDernier(?EcoleProvenances $ecoleProvenances): Query
    {
        $qb = $this->createQueryBuilder('e')
            ->where('e.isActif = :isActif')
            ->orderBy('e.fullname', 'ASC')
            ->addOrderBy('e.dateInscription', 'ASC')
            ->setParameter('isActif', true);

        if ($ecoleProvenances) {
            $qb->leftJoin('e.ecoleAnDernier', 'ecoleAnDernier')
                ->andWhere('ecoleAnDernier.id = :ecoleAnDernierId')
                ->setParameter('ecoleAnDernierId', $ecoleProvenances->getId());
        }
        return $qb->getQuery();
    }

    public function findElevesNonExonoresSansFraisScolarites()
    {
        return $this->createQueryBuilder('e')
            ->leftJoin('e.fraisScolarites', 'f')
            ->andWhere('e.statutFinance != :statut')
            ->andWhere('e.isActif = :isActif')
            ->andWhere('e.isAdmis = :isAdmis')
            ->andWhere('f.id IS NULL') // Vérifie que l'élève n'a pas de frais scolarités associés
            ->setParameter('statut', 'exonore')
            ->setParameter('isActif', true)
            ->setParameter('isAdmis', true)
            ->getQuery()
            ->getResult();
    }

    public function findElevesNonExonoresAvecFraisScolarites()
    {
        return $this->createQueryBuilder('e')
            ->leftJoin('e.fraisScolarites', 'f')
            ->andWhere('e.statutFinance != :statut')
            ->andWhere('e.isActif = :isActif')
            ->andWhere('e.isAdmis = :isAdmis')
            ->andWhere('f.id IS NOT NULL') // Vérifie que l'élève n'a pas de frais scolarités associés
            ->setParameter('statut', 'exonore')
            ->setParameter('isActif', true)
            ->setParameter('isAdmis', true)
            ->getQuery()
            ->getResult();
    }



    //    /**
    //     * @return Eleves[] Returns an array of Eleves objects
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

    //    public function findOneBySomeField($value): ?Eleves
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}