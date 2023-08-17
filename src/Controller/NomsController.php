<?php

namespace App\Controller;

use App\Entity\Noms;
use App\Form\NomsType;
use App\Repository\NomsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\Cache;

#[Route('/noms')]
class NomsController extends AbstractController
{
    #[Route('/', name: 'app_noms_index', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function index(NomsRepository $nomsRepository): Response
    {
        return $this->render('noms/index.html.twig', [
            'noms' => $nomsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_noms_new', methods: ['GET', 'POST'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $nom = new Noms();
        $form = $this->createForm(NomsType::class, $nom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($nom);
            $entityManager->flush();

            return $this->redirectToRoute('app_noms_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('noms/new.html.twig', [
            'nom' => $nom,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_noms_show', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function show(Noms $nom): Response
    {
        return $this->render('noms/show.html.twig', [
            'nom' => $nom,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_noms_edit', methods: ['GET', 'POST'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function edit(Request $request, Noms $nom, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NomsType::class, $nom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_noms_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('noms/edit.html.twig', [
            'nom' => $nom,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_noms_delete', methods: ['POST'])]
    public function delete(Request $request, Noms $nom, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $nom->getId(), $request->request->get('_token'))) {
            $entityManager->remove($nom);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_noms_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route("/ajout/ajax/{label}", name: 'app_noms_ajout_ajax', methods: ['POST'])]
    public function ajoutAjax(string $label, Request $request, EntityManagerInterface $entityManager): Response
    {
        $nom = new Noms();
        $nom->setDesignation(trim(strip_tags($label)));
        $entityManager->persist($nom);
        $entityManager->flush();
        //on récupère l'Id qui a été créé
        $id = $nom->getId();

        return new JsonResponse(['id' => $id]);
    }
}
