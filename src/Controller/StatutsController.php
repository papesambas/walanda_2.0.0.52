<?php

namespace App\Controller;

use App\Entity\Statuts;
use App\Form\StatutsType;
use App\Repository\StatutsRepository;
use App\Service\eleveService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\Cache;

#[Route('/statuts')]
class StatutsController extends AbstractController
{
    #[Route('/', name: 'app_statuts_index', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function index(StatutsRepository $statutsRepository): Response
    {
        return $this->render('statuts/index.html.twig', [
            'statuts' => $statutsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_statuts_new', methods: ['GET', 'POST'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $statut = new Statuts();
        $form = $this->createForm(StatutsType::class, $statut);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($statut);
            $entityManager->flush();

            return $this->redirectToRoute('app_statuts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('statuts/new.html.twig', [
            'statut' => $statut,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_statuts_show', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function show(Statuts $statut, eleveService $eleveService): Response
    {
        return $this->render('statuts/show.html.twig', [
            'statut' => $statut,
            'eleves' => $eleveService->getPaginatedElevesStatut($statut)
        ]);
    }

    #[Route('/{slug}/edit', name: 'app_statuts_edit', methods: ['GET', 'POST'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function edit(Request $request, Statuts $statut, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StatutsType::class, $statut);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_statuts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('statuts/edit.html.twig', [
            'statut' => $statut,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_statuts_delete', methods: ['POST'])]
    public function delete(Request $request, Statuts $statut, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $statut->getId(), $request->request->get('_token'))) {
            $entityManager->remove($statut);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_statuts_index', [], Response::HTTP_SEE_OTHER);
    }
}
