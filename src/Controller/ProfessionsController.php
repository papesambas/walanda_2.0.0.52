<?php

namespace App\Controller;

use App\Entity\Professions;
use App\Form\ProfessionsType;
use App\Repository\ProfessionsRepository;
use App\Service\parentService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\Cache;

#[Route('/professions')]
class ProfessionsController extends AbstractController
{
    #[Route('/', name: 'app_professions_index', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function index(ProfessionsRepository $professionsRepository): Response
    {
        return $this->render('professions/index.html.twig', [
            'professions' => $professionsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_professions_new', methods: ['GET', 'POST'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $profession = new Professions();
        $form = $this->createForm(ProfessionsType::class, $profession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($profession);
            $entityManager->flush();

            return $this->redirectToRoute('app_professions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('professions/new.html.twig', [
            'profession' => $profession,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_professions_show', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function show(Professions $profession, parentService $parentService): Response
    {
        return $this->render('professions/show.html.twig', [
            'profession' => $profession,
            'parents' => $parentService->getPaginatedParents($profession),
        ]);
    }

    #[Route('/{slug}/edit', name: 'app_professions_edit', methods: ['GET', 'POST'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function edit(Request $request, Professions $profession, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProfessionsType::class, $profession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_professions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('professions/edit.html.twig', [
            'profession' => $profession,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_professions_delete', methods: ['POST'])]
    public function delete(Request $request, Professions $profession, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $profession->getId(), $request->request->get('_token'))) {
            $entityManager->remove($profession);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_professions_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route("/ajout/ajax/{label}", name: 'app_professions_ajout_ajax', methods: ['POST'])]
    public function ajoutAjax(string $label, Request $request, EntityManagerInterface $entityManager): Response
    {
        $profession = new Professions();
        $profession->setDesignation(trim(strip_tags($label)));
        $entityManager->persist($profession);
        $entityManager->flush();
        //on récupère l'Id qui a été créé
        $id = $profession->getId();

        return new JsonResponse(['id' => $id]);
    }
}