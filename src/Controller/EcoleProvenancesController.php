<?php

namespace App\Controller;

use App\Entity\EcoleProvenances;
use App\Form\EcoleProvenancesType;
use App\Repository\EcoleProvenancesRepository;
use App\Repository\ElevesRepository;
use App\Service\eleveService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\Cache;

#[Route('/ecole/provenances')]
class EcoleProvenancesController extends AbstractController
{
    #[Route('/', name: 'app_ecole_provenances_index', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function index(EcoleProvenancesRepository $ecoleProvenancesRepository): Response
    {
        return $this->render('ecole_provenances/index.html.twig', [
            'ecole_provenances' => $ecoleProvenancesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ecole_provenances_new', methods: ['GET', 'POST'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ecoleProvenance = new EcoleProvenances();
        $form = $this->createForm(EcoleProvenancesType::class, $ecoleProvenance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ecoleProvenance);
            $entityManager->flush();

            return $this->redirectToRoute('app_ecole_provenances_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ecole_provenances/new.html.twig', [
            'ecole_provenance' => $ecoleProvenance,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ecole_provenances_show', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function show(EcoleProvenances $ecoleProvenance): Response
    {
        return $this->render('ecole_provenances/show.html.twig', [
            'ecole_provenance' => $ecoleProvenance,
        ]);
    }

    #[Route('/{slug}/recrutement', name: 'app_recrutement_show', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function showRecrutement(EcoleProvenances $ecoleProvenance, eleveService $eleveService): Response
    {
        return $this->render('ecole_provenances/showEcole.html.twig', [
            'ecole_provenance' => $ecoleProvenance,
            'eleves' => $eleveService->getPaginatedElevesRecrutement($ecoleProvenance),
        ]);
    }

    #[Route('/{slug}/an/dernier', name: 'app_an_dernier_show', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function showAnDernier(EcoleProvenances $ecoleProvenance, eleveService $eleveService): Response
    {
        return $this->render('ecole_provenances/showEcole.html.twig', [
            'ecole_provenance' => $ecoleProvenance,
            'eleves' => $eleveService->getPaginatedElevesAnDernier($ecoleProvenance),
        ]);
    }

    #[Route('/{slug}/edit', name: 'app_ecole_provenances_edit', methods: ['GET', 'POST'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function edit(Request $request, EcoleProvenances $ecoleProvenance, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EcoleProvenancesType::class, $ecoleProvenance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ecole_provenances_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ecole_provenances/edit.html.twig', [
            'ecole_provenance' => $ecoleProvenance,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ecole_provenances_delete', methods: ['POST'])]
    public function delete(Request $request, EcoleProvenances $ecoleProvenance, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $ecoleProvenance->getId(), $request->request->get('_token'))) {
            $entityManager->remove($ecoleProvenance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ecole_provenances_index', [], Response::HTTP_SEE_OTHER);
    }
}
