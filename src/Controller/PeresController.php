<?php

namespace App\Controller;

use App\Entity\Peres;
use App\Form\PeresType;
use App\Repository\MeresRepository;
use App\Repository\PeresRepository;
use App\Repository\TelephonesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\Cache;

#[Route('/peres')]
class PeresController extends AbstractController
{
    private $telephonesRepository;
    private $meresRepository;
    public function __construct(TelephonesRepository $telephonesRepository, MeresRepository $meresRepository)
    {
        $this->telephonesRepository = $telephonesRepository;
        $this->meresRepository = $meresRepository;
    }

    #[Route('/', name: 'app_peres_index', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function index(PeresRepository $peresRepository): Response
    {
        return $this->render('peres/index.html.twig', [
            'peres' => $peresRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_peres_new', methods: ['GET', 'POST'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pere = new Peres();
        $form = $this->createForm(PeresType::class, $pere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($pere);
            $entityManager->flush();

            return $this->redirectToRoute('app_peres_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('peres/new.html.twig', [
            'pere' => $pere,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_peres_show', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function show(Peres $pere): Response
    {
        return $this->render('peres/show.html.twig', [
            'pere' => $pere,
        ]);
    }

    #[Route('/{slug}/edit', name: 'app_peres_edit', methods: ['GET', 'POST'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function edit(Request $request, Peres $pere, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PeresType::class, $pere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_peres_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('peres/edit.html.twig', [
            'pere' => $pere,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_peres_delete', methods: ['POST'])]
    public function delete(Request $request, Peres $pere, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $pere->getId(), $request->request->get('_token'))) {
            $entityManager->remove($pere);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_peres_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route("/telephones/search/ajax/{telephoneId}", name: 'app_peres_telephones_search_ajax', methods: ['GET', 'POST'])]
    public function ajoutAjax(int $telephoneId, PeresRepository $peresRepository, Request $request, TelephonesRepository $telephonesRepository): Response
    {
        $telephone = $telephonesRepository->findOneBy(['id' => $telephoneId]);
        $pere = $peresRepository->findOneByTelephone($telephoneId);
        $mere = $this->meresRepository->findOneByTelephone($telephoneId);
        if ($pere !== null) {
            // Récupérez les informations nécessaires de la père pour les passer au formulaire
            $pereId = $pere->getId() ? $pere->getId() : null;
            $nomId = $pere->getNom() ? $pere->getNom()->getId() : null;
            $prenomId = $pere->getPrenom() ? $pere->getPrenom()->getId() : null;
            $professionId = $pere->getProfession() ? $pere->getProfession()->getId() : null;
            $telephoneId = $pere->getTelephone() ? $pere->getTelephone()->getId() : null;
            $ninaId = $pere->getNina() ? $pere->getNina()->getId() : null;


            // Récupérer les noms, prénoms et professions associés à la père
            $nom = $pere->getNom() ? $pere->getNom()->getDesignation() : null;
            $prenom = $pere->getPrenom() ? $pere->getPrenom()->getDesignation() : null;
            $profession = $pere->getProfession() ? $pere->getProfession()->getDesignation() : null;
            $telephone = $pere->getTelephone() ? $pere->getTelephone()->getNumero() : null;
            $nina = $pere->getNina() ? $pere->getNina()->getDesignation() : null;

            return new JsonResponse([
                'pereId' => $pereId,
                'nomId' => $nomId,
                'prenomId' => $prenomId,
                'professionId' => $professionId,
                'telephoneId' => $telephoneId,
                'ninaId' => $ninaId,
                'nom' => $nom,
                'prenom' => $prenom,
                'profession' => $profession,
                'telephone' => $telephone,
                'nina' => $nina
            ]);
        } elseif ($pere == null && $mere !== null && $telephone !== null) {
            $pereId = $mere->getId() ? $mere->getId() : null;
            $nomId = $mere->getNom() ? $mere->getNom()->getId() : null;
            $prenomId = $mere->getPrenom() ? $mere->getPrenom()->getId() : null;
            $professionId = $mere->getProfession() ? $mere->getProfession()->getId() : null;
            $telephoneId = $mere->getTelephone() ? $mere->getTelephone()->getId() : null;
            $ninaId = $mere->getNina() ? $mere->getNina()->getId() : null;


            // Récupérer les noms, prénoms et professions associés à la père
            $nom = $mere->getNom() ? $mere->getNom()->getDesignation() : null;
            $prenom = $mere->getPrenom() ? $mere->getPrenom()->getDesignation() : null;
            $profession = $mere->getProfession() ? $mere->getProfession()->getDesignation() : null;
            $telephone = $mere->getTelephone() ? $mere->getTelephone()->getNumero() : null;
            $nina = $mere->getNina() ? $mere->getNina()->getDesignation() : null;

            $this->addFlash('danger', 'Le téléphone sollicité pour un père, est déjà associé à une mère');
            $response = new JsonResponse([
                'errorTel' => 'Le téléphone sollicité pour un père, est déjà associé à une mère',
                'pereId' => $pereId,
                'nomId' => $nomId,
                'prenomId' => $prenomId,
                'professionId' => $professionId,
                'telephoneId' => $telephoneId,
                'ninaId' => $ninaId,
                'nom' => $nom,
                'prenom' => $prenom,
                'profession' => $profession,
                'telephone' => $telephone,
                'nina' => $nina
            ]);
            $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
            return $response;
        } elseif ($pere == null && $mere == null && $telephone !== null) {
            return new JsonResponse([
                'errorTele' => 'Le téléphone existe, mais il n\'a pas de père associé.',
                'telephoneId' => $telephone->getId(),
                'telephone' => $telephone->getNumero(),

                'pereId' => null,
                'nomId' => null,
                'prenomId' => null,
                'professionId' => null,
                'ninaId' => null,
                'nom' => null,
                'prenom' => null,
                'profession' => null,
                'nina' => null
            ]);
        } else {
            $numero = '+' . $telephoneId;
            $telephone = $this->telephonesRepository->findOneByNumero($numero);
            $telephoneId = $telephone->getId();
            // Le téléphone existe, mais il n'a pas de père associée
            return new JsonResponse([
                'error' => "ce numéro vient d'être créé !!!",
                'telephoneId' => $telephoneId,
                'telephone' => $telephone->getNumero(),

                'pereId' => null,
                'nomId' => null,
                'prenomId' => null,
                'professionId' => null,
                'ninaId' => null,
                'nom' => null,
                'prenom' => null,
                'profession' => null,
                'nina' => null
            ]);
        }
    }
}