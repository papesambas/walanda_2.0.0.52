<?php

namespace App\Controller;

use App\Entity\Professions;
use App\Form\ProfessionsType;
use App\Repository\ProfessionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/professions')]
class ProfessionsController extends AbstractController
{
    #[Route('/', name: 'app_professions_index', methods: ['GET'])]
    public function index(ProfessionsRepository $professionsRepository): Response
    {
        return $this->render('professions/index.html.twig', [
            'professions' => $professionsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_professions_new', methods: ['GET', 'POST'])]
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

    #[Route('/{id}', name: 'app_professions_show', methods: ['GET'])]
    public function show(Professions $profession): Response
    {
        return $this->render('professions/show.html.twig', [
            'profession' => $profession,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_professions_edit', methods: ['GET', 'POST'])]
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