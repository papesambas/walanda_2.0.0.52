<?php

namespace App\Controller;

use App\Entity\Communes;
use App\Form\CommunesType;
use App\Repository\CommunesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use symfony\component\HttpKernel\Attribute\Cache;

#[Route('/communes')]
class CommunesController extends AbstractController
{
    #[Route('/', name: 'app_communes_index', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function index(CommunesRepository $communesRepository): Response
    {
        return $this->render('communes/index.html.twig', [
            'communes' => $communesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_communes_new', methods: ['GET', 'POST'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commune = new Communes();
        $form = $this->createForm(CommunesType::class, $commune);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commune);
            $entityManager->flush();

            return $this->redirectToRoute('app_communes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('communes/new.html.twig', [
            'commune' => $commune,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_communes_show', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function show(Communes $commune): Response
    {
        return $this->render('communes/show.html.twig', [
            'commune' => $commune,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_communes_edit', methods: ['GET', 'POST'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function edit(Request $request, Communes $commune, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommunesType::class, $commune);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_communes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('communes/edit.html.twig', [
            'commune' => $commune,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_communes_delete', methods: ['POST'])]
    public function delete(Request $request, Communes $commune, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $commune->getId(), $request->request->get('_token'))) {
            $entityManager->remove($commune);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_communes_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route("/ajout/ajax/{label}", name: 'app_communes_ajout_ajax', methods: ['POST'])]
    public function ajoutAjax(string $label, Request $request, EntityManagerInterface $entityManager): Response
    {
        $commune = new Communes();
        $commune->setDesignation(trim(strip_tags($label)));
        $entityManager->persist($commune);
        $entityManager->flush();
        //on récupère l'Id qui a été créé
        $id = $commune->getId();

        return new JsonResponse(['id' => $id]);
    }
}
