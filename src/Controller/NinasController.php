<?php

namespace App\Controller;

use App\Entity\Ninas;
use App\Form\NinasType;
use App\Repository\NinasRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\Cache;

#[Route('/ninas')]
class NinasController extends AbstractController
{
    #[Route('/', name: 'app_ninas_index', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function index(NinasRepository $ninasRepository): Response
    {
        return $this->render('ninas/index.html.twig', [
            'ninas' => $ninasRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ninas_new', methods: ['GET', 'POST'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $nina = new Ninas();
        $form = $this->createForm(NinasType::class, $nina);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($nina);
            $entityManager->flush();

            return $this->redirectToRoute('app_ninas_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ninas/new.html.twig', [
            'nina' => $nina,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ninas_show', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function show(Ninas $nina): Response
    {
        return $this->render('ninas/show.html.twig', [
            'nina' => $nina,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ninas_edit', methods: ['GET', 'POST'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function edit(Request $request, Ninas $nina, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NinasType::class, $nina);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ninas_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ninas/edit.html.twig', [
            'nina' => $nina,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ninas_delete', methods: ['POST'])]
    public function delete(Request $request, Ninas $nina, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $nina->getId(), $request->request->get('_token'))) {
            $entityManager->remove($nina);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ninas_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route("/ajout/ajax/{label}", name: 'app_ninas_ajout_ajax', methods: ['POST'])]
    public function ajoutAjax(string $label, Request $request, EntityManagerInterface $entityManager): Response
    {
        $nina = new Ninas();
        $nina->setDesignation(trim(strip_tags($label)));
        $entityManager->persist($nina);
        $entityManager->flush();
        //on récupère l'Id qui a été créé
        $id = $nina->getId();

        return new JsonResponse(['id' => $id]);
    }
}
