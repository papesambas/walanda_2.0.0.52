<?php

namespace App\Controller;

use App\Entity\FraisScolarites;
use App\Repository\ElevesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\FraisScolairesRepository;
use App\Repository\FraisScolaritesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\Cache;

class ClotureController extends AbstractController
{
    #[Route('/cloture', name: 'app_cloture')]
    public function index(): Response
    {
        return $this->render('cloture/index.html.twig', [
            'controller_name' => 'ClotureController',
        ]);
    }

    #[Route('/fin/annee', name: 'app_eleves_cloture', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function cloture(
        Request $request,
        ElevesRepository $elevesRepository,
        FraisScolairesRepository $fraisScolairesRepository,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger,
        FraisScolaritesRepository $fraisScolaritesRepository
    ): Response {
        $elevesPresents = $elevesRepository->findElevesNonExonoresAvecFraisScolarites();
        $entityManager->beginTransaction();

        try {
            foreach ($elevesPresents as $elefe) {
                $fraisScolaritesEleves =  $fraisScolaritesRepository->findByEleve($elefe);
                $fraisScolarite = new FraisScolarites();
                $insciption = $fraisScolaritesEleves->getInscription();
                $carnet = $fraisScolaritesEleves->getCarnet();
                $transfert = $fraisScolaritesEleves->getTransfert();
                $Septembre = $fraisScolaritesEleves->getSeptembre();
                $Octobre = $fraisScolaritesEleves->getOctobre();
                $Novembre = $fraisScolaritesEleves->getNovembre();
                $Decembre = $fraisScolaritesEleves->getDecembre();
                $Janvier = $fraisScolaritesEleves->getJanvier();
                $Fevrier = $fraisScolaritesEleves->getFevrier();
                $Mars = $fraisScolaritesEleves->getMars();
                $Avril = $fraisScolaritesEleves->getAvril();
                $Mai = $fraisScolaritesEleves->getMai();
                $Juin = $fraisScolaritesEleves->getJuin();
                $Autre = $fraisScolaritesEleves->getAutre();

                $total = $insciption + $carnet + $transfert + $Septembre + $Octobre + $Novembre + $Decembre + $Janvier + $Fevrier + $Mars + $Avril + $Mai + $Juin + $Autre; // Ajouter l'élément à notre tableau
                $fraisScolaritesEleves->setArrieres(0);
                //$fraisScolaritesRepository->save($fraisScolarite, true);
            }

            //dd($total);            
            $entityManager->flush();
            $entityManager->commit();
        } catch (\Exception $exception) {
            $entityManager->rollback();
            throw $exception;
        }

        return $this->redirectToRoute('app_eleves_index', [], Response::HTTP_SEE_OTHER);
    }
}
