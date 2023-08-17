<?php

namespace App\Controller;

use App\Entity\Regions;
use App\Form\RegionsType;
use App\Repository\RegionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\Cache;

#[Route('/regions')]
class RegionsController extends AbstractController
{
    #[Route('/', name: 'app_regions_index', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function index(RegionsRepository $regionsRepository): Response
    {
        return $this->render('regions/index.html.twig', [
            'regions' => $regionsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_regions_new', methods: ['GET', 'POST'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $region = new Regions();
        $form = $this->createForm(RegionsType::class, $region);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($region);
            $entityManager->flush();

            return $this->redirectToRoute('app_regions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('regions/new.html.twig', [
            'region' => $region,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_regions_show', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function show(Regions $region): Response
    {
        return $this->render('regions/show.html.twig', [
            'region' => $region,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_regions_edit', methods: ['GET', 'POST'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function edit(Request $request, Regions $region, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RegionsType::class, $region);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_regions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('regions/edit.html.twig', [
            'region' => $region,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_regions_delete', methods: ['POST'])]
    public function delete(Request $request, Regions $region, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $region->getId(), $request->request->get('_token'))) {
            $entityManager->remove($region);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_regions_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route("/ajout/ajax/{label}", name: 'app_regions_ajout_ajax', methods: ['POST'])]
    public function ajoutAjax(string $label, Request $request, EntityManagerInterface $entityManager): Response
    {
        $region = new Regions();
        $region->setDesignation(trim(strip_tags($label)));
        $entityManager->persist($region);
        $entityManager->flush();
        //on récupère l'Id qui a été créé
        $id = $region->getId();

        return new JsonResponse(['id' => $id]);
    }
}