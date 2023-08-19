<?php

namespace App\Controller;

use App\Entity\FraisScolaires;
use App\Entity\FraisScolarites;
use App\Form\FraisScolaritesType;
use App\Repository\ElevesRepository;
use App\Repository\FraisScolairesRepository;
use App\Repository\FraisScolaritesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/frais/scolarites')]
class FraisScolaritesController extends AbstractController
{
    #[Route('/', name: 'app_frais_scolarites_index', methods: ['GET'])]
    public function index(FraisScolaritesRepository $fraisScolaritesRepository): Response
    {
        return $this->render('frais_scolarites/index.html.twig', [
            'frais_scolarites' => $fraisScolaritesRepository->findAll(),
        ]);
    }



    #[Route('/new', name: 'app_frais_scolarites_new', methods: ['GET', 'POST'])]

    public function new(Request $request, EntityManagerInterface $entityManager, ElevesRepository $elevesRepository, FraisScolairesRepository $fraisScolairesRepository): Response
    {
        $elevesNonExonoresSansFraisScolarites = $elevesRepository->findElevesNonExonoresSansFraisScolarites();

        $entityManager->beginTransaction();

        try {
            foreach ($elevesNonExonoresSansFraisScolarites as $eleve) {
                $fraisScolarite = $fraisScolairesRepository->findOneFraisScolariteByNiveauAndStatut($eleve->getClasse()->getNiveau(), $eleve->getStatut());

                if ($fraisScolarite) {
                    $nouveauFraisScolarite = new FraisScolarites();
                    $nouveauFraisScolarite->setEleve($eleve);
                    $nouveauFraisScolarite->setCarnet($fraisScolarite->getFraisCarnet());
                    $nouveauFraisScolarite->setTransfert($fraisScolarite->getFraisTransfert());
                    $nouveauFraisScolarite->setSeptembre($fraisScolarite->getSeptembre());
                    $nouveauFraisScolarite->setOctobre($fraisScolarite->getOctobre());
                    $nouveauFraisScolarite->setNovembre($fraisScolarite->getNovembre());
                    $nouveauFraisScolarite->setDecembre($fraisScolarite->getDecembre());
                    $nouveauFraisScolarite->setJanvier($fraisScolarite->getJanvier());
                    $nouveauFraisScolarite->setFevrier($fraisScolarite->getFevrier());
                    $nouveauFraisScolarite->setMars($fraisScolarite->getMars());
                    $nouveauFraisScolarite->setAvril($fraisScolarite->getAvril());
                    $nouveauFraisScolarite->setMai($fraisScolarite->getMai());
                    $nouveauFraisScolarite->setJuin($fraisScolarite->getJuin());
                    $nouveauFraisScolarite->setAutre($fraisScolarite->getAutres());
                    $entityManager->persist($nouveauFraisScolarite);

                    $entityManager->persist($nouveauFraisScolarite);
                }
            }

            $entityManager->flush();
            $entityManager->commit();
        } catch (\Exception $exception) {
            $entityManager->rollback();
            throw $exception;
        }

        // Créer et gérer le formulaire
        $fraisScolarite = new FraisScolarites();
        $form = $this->createForm(FraisScolaritesType::class, $fraisScolarite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($fraisScolarite);
            $entityManager->flush();

            return $this->redirectToRoute('app_frais_scolarites_index', [], Response::HTTP_SEE_OTHER);
        }

        // ... Le reste de votre code pour afficher le formulaire et la vue

        return $this->render('frais_scolarites/new.html.twig', [
            'frais_scolarite' => $fraisScolarite,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_frais_scolarites_show', methods: ['GET'])]
    public function show(FraisScolarites $fraisScolarite): Response
    {
        return $this->render('frais_scolarites/show.html.twig', [
            'frais_scolarite' => $fraisScolarite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_frais_scolarites_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FraisScolarites $fraisScolarite, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FraisScolaritesType::class, $fraisScolarite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_frais_scolarites_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('frais_scolarites/edit.html.twig', [
            'frais_scolarite' => $fraisScolarite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_frais_scolarites_delete', methods: ['POST'])]
    public function delete(Request $request, FraisScolarites $fraisScolarite, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $fraisScolarite->getId(), $request->request->get('_token'))) {
            $entityManager->remove($fraisScolarite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_frais_scolarites_index', [], Response::HTTP_SEE_OTHER);
    }
}