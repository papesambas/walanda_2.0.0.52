<?php

namespace App\Controller;

use App\Entity\Prenoms;
use App\Form\PrenomsType;
use App\Repository\PrenomsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\Cache;

#[Route('/prenoms')]
class PrenomsController extends AbstractController
{
    #[Route('/', name: 'app_prenoms_index', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function index(PrenomsRepository $prenomsRepository): Response
    {
        return $this->render('prenoms/index.html.twig', [
            'prenoms' => $prenomsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_prenoms_new', methods: ['GET', 'POST'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $prenom = new Prenoms();
        $form = $this->createForm(PrenomsType::class, $prenom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($prenom);
            $entityManager->flush();

            return $this->redirectToRoute('app_prenoms_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('prenoms/new.html.twig', [
            'prenom' => $prenom,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_prenoms_show', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function show(Prenoms $prenom): Response
    {
        return $this->render('prenoms/show.html.twig', [
            'prenom' => $prenom,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_prenoms_edit', methods: ['GET', 'POST'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function edit(Request $request, Prenoms $prenom, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PrenomsType::class, $prenom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_prenoms_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('prenoms/edit.html.twig', [
            'prenom' => $prenom,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_prenoms_delete', methods: ['POST'])]
    public function delete(Request $request, Prenoms $prenom, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $prenom->getId(), $request->request->get('_token'))) {
            $entityManager->remove($prenom);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_prenoms_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route("/ajout/ajax/{label}", name: 'app_prenoms_ajout_ajax', methods: ['POST'])]
    public function ajoutAjax(string $label, Request $request, EntityManagerInterface $entityManager): Response
    {
        $prenom = new Prenoms();
        $prenom->setDesignation(trim(strip_tags($label)));
        $entityManager->persist($prenom);
        $entityManager->flush();
        //on récupère l'Id qui a été créé
        $id = $prenom->getId();

        return new JsonResponse(['id' => $id]);
    }
}
