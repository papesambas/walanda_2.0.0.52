<?php

namespace App\Repository;

use App\Entity\Meres;
use App\Entity\Parents;
use App\Entity\Peres;
use App\Entity\Professions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @extends ServiceEntityRepository<Parents>
 *
 * @method Parents|null find($id, $lockMode = null, $lockVersion = null)
 * @method Parents|null findOneBy(array $criteria, array $orderBy = null)
 * @method Parents[]    findAll()
 * @method Parents[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Parents::class);
    }

    /**
     * Undocumented function
     *
     * @param [type] $pere
     * @param [type] $mere
     * @return Parents|null
     */
    public function findOneByPereAndMere($pere, $mere): ?Parents
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.pere = :pere')
            ->andWhere('p.mere = :mere')
            ->setParameter('pere', $pere)
            ->setParameter('mere', $mere)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findForPagination(?Professions $professions): Query
    {
        $qb = $this->createQueryBuilder('p')
            ->leftJoin('p.pere', 'pe')
            ->leftJoin('pe.profession', 'professionPere')
            ->leftJoin('p.mere', 'me')
            ->leftJoin('me.profession', 'professionMere')
            ->orderBy('pe.fullname', 'ASC')
            ->addOrderBy('me.fullname', 'ASC');

        if ($professions) {
            $qb->andWhere($qb->expr()->orX(
                $qb->expr()->eq('professionPere', ':profession'),
                $qb->expr()->eq('professionMere', ':profession')
            ))
                ->setParameter('profession', $professions);
        }

        return $qb->getQuery();
    }


    //    /**
    //     * @return Parents[] Returns an array of Parents objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Parents
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}