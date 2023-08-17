<?php

namespace App\Controller;

use App\Entity\Niveaux;
use App\Form\NiveauxType;
use App\Repository\NiveauxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\Cache;

#[Route('/niveaux')]
class NiveauxController extends AbstractController
{
    #[Route('/', name: 'app_niveaux_index', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function index(NiveauxRepository $niveauxRepository): Response
    {
        return $this->render('niveaux/index.html.twig', [
            'niveauxes' => $niveauxRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_niveaux_new', methods: ['GET', 'POST'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $niveau = new Niveaux();
        $form = $this->createForm(NiveauxType::class, $niveau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($niveau);
            $entityManager->flush();

            return $this->redirectToRoute('app_niveaux_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('niveaux/new.html.twig', [
            'niveau' => $niveau,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_niveaux_show', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function show(Niveaux $niveau): Response
    {
        return $this->render('niveaux/show.html.twig', [
            'niveau' => $niveau,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_niveaux_edit', methods: ['GET', 'POST'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function edit(Request $request, Niveaux $niveau, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NiveauxType::class, $niveau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_niveaux_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('niveaux/edit.html.twig', [
            'niveau' => $niveau,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_niveaux_delete', methods: ['POST'])]
    public function delete(Request $request, Niveaux $niveau, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $niveau->getId(), $request->request->get('_token'))) {
            $entityManager->remove($niveau);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_niveaux_index', [], Response::HTTP_SEE_OTHER);
    }
}
