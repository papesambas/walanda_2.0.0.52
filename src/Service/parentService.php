<?php

namespace App\Service;

use App\Entity\Meres;
use App\Entity\Peres;
use App\Entity\Classes;
use App\Entity\Statuts;
use App\Entity\Departements;
use App\Entity\LieuNaissance;
use App\Entity\LieuNaissances;
use App\Entity\EcoleProvenances;
use App\Entity\Professions;
use App\Repository\ElevesRepository;
use App\Repository\ParentsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class parentService
{
    public function __construct(private RequestStack $requestStack, private ParentsRepository $parentsRepos, private PaginatorInterface $paginator)

    {
    }

    public function getPaginatedParents(?Professions $professions = null)
    {
        $request = $this->requestStack->getMainRequest();
        $page = $request->query->getInt('page', 1);
        $limit = 15;
        $parentQuery = $this->parentsRepos->findForPagination($professions);
        return $this->paginator->paginate($parentQuery, $page, $limit);
    }


    /*public function getPaginationElevesPere(?Peres $peres = null)
    {
        $request = $this->requestStack->getMainRequest();
        $page = $request->query->getInt('page', 1);
        $limit = 15;
        $eleveQuery = $this->elevesRepos->findForPaginationPere($peres);
        return $this->paginator->paginate($eleveQuery, $page, $limit);
    }
    public function getPaginatedElevesMere(?Meres $meres = null)
    {
        $request = $this->requestStack->getMainRequest();
        $page = $request->query->getInt('page', 1);
        $limit = 15;
        $eleveQuery = $this->elevesRepos->findForPaginationMere($meres);
        return $this->paginator->paginate($eleveQuery, $page, $limit);
    }*/
}
