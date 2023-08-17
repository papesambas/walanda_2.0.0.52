<?php

namespace App\Controller;

use App\Entity\Classes;
use App\Form\ClassesType;
use App\Repository\ClassesRepository;
use App\Service\eleveService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\Cache;

#[Route('/classes')]
class ClassesController extends AbstractController
{
    #[Route('/', name: 'app_classes_index', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function index(ClassesRepository $classesRepository): Response
    {
        return $this->render('classes/index.html.twig', [
            'classes' => $classesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_classes_new', methods: ['GET', 'POST'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $class = new Classes();
        $form = $this->createForm(ClassesType::class, $class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($class);
            $entityManager->flush();

            return $this->redirectToRoute('app_classes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/new.html.twig', [
            'class' => $class,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_classes_show', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function show(Classes $class, eleveService $eleveService): Response
    {
        return $this->render('classes/show.html.twig', [
            'class' => $class,
            'eleves' => $eleveService->getPaginatedEleves($class),
        ]);
    }

    #[Route('/{slug}/edit', name: 'app_classes_edit', methods: ['GET', 'POST'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function edit(Request $request, Classes $class, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClassesType::class, $class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_classes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/edit.html.twig', [
            'class' => $class,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classes_delete', methods: ['POST'])]
    public function delete(Request $request, Classes $class, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $class->getId(), $request->request->get('_token'))) {
            $entityManager->remove($class);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_classes_index', [], Response::HTTP_SEE_OTHER);
    }
}
