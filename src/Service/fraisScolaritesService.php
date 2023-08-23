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
use App\Repository\ElevesRepository;
use App\Repository\FraisScolaritesRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class fraisScolaritesService
{
    public function __construct(private RequestStack $requestStack, private FraisScolaritesRepository $fraisScolaritesRepos, private PaginatorInterface $paginator)

    {
    }

    public function getPaginatedEleves(?Classes $classes = null)
    {
        $request = $this->requestStack->getMainRequest();
        $page = $request->query->getInt('page', 1);
        $limit = 15;
        $fraisQuery = $this->fraisScolaritesRepos->findForPagination($classes);
        return $this->paginator->paginate($fraisQuery, $page, $limit);
    }
}
