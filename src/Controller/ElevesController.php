<?php

namespace App\Controller;

use App\Entity\Eleves;
use App\Entity\Parents;
use App\Form\ElevesType;
use App\Entity\DossierEleves;
use App\Service\eleveService;
use App\Entity\FraisScolarites;
use App\Repository\ElevesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\FraisScolairesRepository;
use App\Repository\FraisScolaritesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\Cache;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/eleves')]
class ElevesController extends AbstractController
{
    #[Route('/', name: 'app_eleves_index', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function index(eleveService $eleveService): Response
    {
        $eleves = $eleveService->getPaginatedEleves();
        return $this->render('eleves/index.html.twig', [
            'eleves' => $eleves,
        ]);
    }

    #[Route('/new', name: 'app_eleves_new', methods: ['GET', 'POST'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function new(Request $request, EntityManagerInterface $entityManager, ElevesRepository $elevesRepository, FraisScolairesRepository $fraisScolairesRepository, SluggerInterface $slugger): Response
    {
        $elefe = new Eleves();

        $parentId = $request->query->getInt('parent_id', 0);
        if ($parentId > 0) {
            // Récupérer le parent à partir de l'ID
            $parent = $entityManager->getRepository(Parents::class)->findOneById($parentId);
            if ($parent) {
                // Associer le parent à l'élève
                $elefe->setParent($parent);
            }
        }

        $form = $this->createForm(ElevesType::class, $elefe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $documents = $form->get('document')->getData();
            //$extrait = $form->get('extrait')->getData();
            foreach ($documents as $document) {
                $originalFilename = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $document->guessExtension();
                $fichier = md5(uniqid()) . '.' . $document->guessExtension();

                //On copie le fichier dans le dossier upload
                $document->move(
                    $this->getParameter('documents_eleves_directory'),
                    $originalFilename
                );

                //On stock le nom du document dans la base de donnée
                $docum = new DossierEleves;
                $docum->setDesignation($originalFilename);
                $docum->setSlug($fichier);
                $elefe->addDossier($docum);
            }

            $entityManager->persist($elefe);
            $entityManager->flush();

            $elevesNonExonoresSansFraisScolarites = $elevesRepository->findElevesNonExonoresSansFraisScolarites();

            $entityManager->beginTransaction();

            try {
                foreach ($elevesNonExonoresSansFraisScolarites as $eleve) {
                    $fraisScolarite = $fraisScolairesRepository->findOneFraisScolariteByNiveauAndStatut($eleve->getClasse()->getNiveau(), $eleve->getStatut());

                    if ($fraisScolarite) {
                        $nouveauFraisScolarite = new FraisScolarites();
                        $nouveauFraisScolarite->setEleve($eleve);
                        $nouveauFraisScolarite->setInscription($fraisScolarite->getFraisInscription());
                        $nouveauFraisScolarite->setCarnet($fraisScolarite->getFraisCarnet());
                        $nouveauFraisScolarite->setTransfert($fraisScolarite->getFraisTransfert());
                        $nouveauFraisScolarite->setSeptembre($fraisScolarite->getSeptembre());
                        $nouveauFraisScolarite->setOctobre($fraisScolarite->getOctobre());
                        $nouveauFraisScolarite->setNovembre($fraisScolarite->getNovembre());
                        $nouveauFraisScolarite->setDecembre($fraisScolarite->getDecembre());
                        $nouveauFraisScolarite->setJanvier($fraisScolarite->getJanvier());
                        $nouveauFraisScolarite->setFevrier($fraisScolarite->getFevrier());
                        $nouveauFraisScolarite->setMars($fraisScolarite->getMars());
                        $nouveauFraisScolarite->setAvril($fraisScolarite->getAvril());
                        $nouveauFraisScolarite->setMai($fraisScolarite->getMai());
                        $nouveauFraisScolarite->setJuin($fraisScolarite->getJuin());
                        $nouveauFraisScolarite->setAutre($fraisScolarite->getAutres());
                        $entityManager->persist($nouveauFraisScolarite);

                        $entityManager->persist($nouveauFraisScolarite);
                    }
                }

                $entityManager->flush();
                $entityManager->commit();
            } catch (\Exception $exception) {
                $entityManager->rollback();
                throw $exception;
            }

            return $this->redirectToRoute('app_eleves_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('eleves/new.html.twig', [
            'elefe' => $elefe,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_eleves_show', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function show(Eleves $elefe): Response
    {
        return $this->render('eleves/show.html.twig', [
            'elefe' => $elefe,
        ]);
    }

    #[Route('/{slug}/edit', name: 'app_eleves_edit', methods: ['GET', 'POST'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function edit(Request $request, Eleves $elefe, ElevesRepository $elevesRepository, FraisScolairesRepository $fraisScolairesRepository, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ElevesType::class, $elefe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $documents = $form->get('document')->getData();
            //$extrait = $form->get('extrait')->getData();
            foreach ($documents as $document) {
                $originalFilename = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $document->guessExtension();
                $fichier = md5(uniqid()) . '.' . $document->guessExtension();

                //On copie le fichier dans le dossier upload
                $document->move(
                    $this->getParameter('documents_eleves_directory'),
                    $originalFilename
                );

                //On stock le nom du document dans la base de donnée
                $docum = new DossierEleves;
                $docum->setDesignation($originalFilename);
                $docum->setSlug($fichier);
                $elefe->addDossier($docum);
            }

            $entityManager->flush();

            $elevesNonExonoresSansFraisScolarites = $elevesRepository->findElevesNonExonoresSansFraisScolarites();

            $entityManager->beginTransaction();

            try {
                foreach ($elevesNonExonoresSansFraisScolarites as $eleve) {
                    $fraisScolarite = $fraisScolairesRepository->findOneFraisScolariteByNiveauAndStatut($eleve->getClasse()->getNiveau(), $eleve->getStatut());

                    if ($fraisScolarite) {
                        $nouveauFraisScolarite = new FraisScolarites();
                        $nouveauFraisScolarite->setEleve($eleve);
                        $nouveauFraisScolarite->setInscription($fraisScolarite->getFraisInscription());
                        $nouveauFraisScolarite->setCarnet($fraisScolarite->getFraisCarnet());
                        $nouveauFraisScolarite->setTransfert($fraisScolarite->getFraisTransfert());
                        $nouveauFraisScolarite->setSeptembre($fraisScolarite->getSeptembre());
                        $nouveauFraisScolarite->setOctobre($fraisScolarite->getOctobre());
                        $nouveauFraisScolarite->setNovembre($fraisScolarite->getNovembre());
                        $nouveauFraisScolarite->setDecembre($fraisScolarite->getDecembre());
                        $nouveauFraisScolarite->setJanvier($fraisScolarite->getJanvier());
                        $nouveauFraisScolarite->setFevrier($fraisScolarite->getFevrier());
                        $nouveauFraisScolarite->setMars($fraisScolarite->getMars());
                        $nouveauFraisScolarite->setAvril($fraisScolarite->getAvril());
                        $nouveauFraisScolarite->setMai($fraisScolarite->getMai());
                        $nouveauFraisScolarite->setJuin($fraisScolarite->getJuin());
                        $nouveauFraisScolarite->setAutre($fraisScolarite->getAutres());
                        $entityManager->persist($nouveauFraisScolarite);

                        $entityManager->persist($nouveauFraisScolarite);
                    }
                }

                $entityManager->flush();
                $entityManager->commit();
            } catch (\Exception $exception) {
                $entityManager->rollback();
                throw $exception;
            }


            return $this->redirectToRoute('app_eleves_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('eleves/edit.html.twig', [
            'elefe' => $elefe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_eleves_delete', methods: ['POST'])]
    public function delete(Request $request, Eleves $elefe, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $elefe->getId(), $request->request->get('_token'))) {
            $entityManager->remove($elefe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_eleves_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/delete/document/{id}', name: 'app_eleve_documents_delete', methods: ['DELETE'])]
    public function deleteDocument(Request $request, DossierEleves $document, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), true);
        //On vérifie si le token est valide
        if ($this->isCsrfTokenValid('delete' . $document->getId(), $data['_token'])) {
            //On récupère le nom du document
            $designation = $document->getDesignation();
            //On supprime de la base
            $entityManager->remove($document);
            $entityManager->flush();

            //On supprime le fichier
            unlink($this->getParameter('documents_eleves_directory') . '/' . $designation);

            // On repond en json
            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => "Token Invalide"], 400);
        }
    }

    #[Route('/fin/annee', name: 'app_eleves_cloture', methods: ['GET'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function cloture(
        Request $request,
        ElevesRepository $elevesRepository,
        FraisScolairesRepository $fraisScolairesRepository,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger,
        FraisScolaritesRepository $fraisScolaritesRepository
    ): Response {
        $elevesPresents = $elevesRepository->findElevesNonExonoresAvecFraisScolarites();
        $entityManager->beginTransaction();

        try {
            foreach ($elevesPresents as $elefe) {
                $fraisScolaritesEleves =  $fraisScolaritesRepository->findByEleve($elefe);
                $fraisScolarite = new FraisScolarites();
                $insciption = $fraisScolaritesEleves->getInscription();
                $carnet = $fraisScolaritesEleves->getCarnet();
                $transfert = $fraisScolaritesEleves->getTransfert();
                $Septembre = $fraisScolaritesEleves->getSeptembre();
                $Octobre = $fraisScolaritesEleves->getOctobre();
                $Novembre = $fraisScolaritesEleves->getNovembre();
                $Decembre = $fraisScolaritesEleves->getDecembre();
                $Janvier = $fraisScolaritesEleves->getJanvier();
                $Fevrier = $fraisScolaritesEleves->getFevrier();
                $Mars = $fraisScolaritesEleves->getMars();
                $Avril = $fraisScolaritesEleves->getAvril();
                $Mai = $fraisScolaritesEleves->getMai();
                $Juin = $fraisScolaritesEleves->getJuin();
                $Autre = $fraisScolaritesEleves->getAutre();

                $total = $insciption + $carnet + $transfert + $Septembre + $Octobre + $Novembre + $Decembre + $Janvier + $Fevrier + $Mars + $Avril + $Mai + $Juin + $Autre; // Ajouter l'élément à notre tableau
                $fraisScolaritesEleves->setArrieres(0);
                //$fraisScolaritesRepository->save($fraisScolarite, true);
            }

            //dd($total);            
            $entityManager->flush();
            $entityManager->commit();
        } catch (\Exception $exception) {
            $entityManager->rollback();
            throw $exception;
        }

        return $this->redirectToRoute('app_eleves_index', [], Response::HTTP_SEE_OTHER);
    }
}
