<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Eleves;
use App\Entity\Parents;
use App\Form\ElevesType;
use App\Entity\DossierEleves;
use App\Service\eleveService;
use App\Entity\FraisScolarites;
use App\Repository\ElevesRepository;
use App\Entity\FraisScolaritesAbandon;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\FraisScolairesRepository;
use App\Repository\FraisScolaritesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\Cache;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\FraisScolaritesAbandonRepository;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $PasswordHasher, ElevesRepository $elevesRepository, FraisScolairesRepository $fraisScolairesRepository, SluggerInterface $slugger): Response
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

            $suffix = substr(time(), -4);

            $user = new Users();
            $password = 'password';
            $email = "inscription@EMPT.edu";
            $userNom = $elefe->getNom();
            $userPrenom = $elefe->getPrenom();
            $userFullname = $elefe->getNom() . ' ' . $elefe->getPrenom();
            $username = $elefe->getNom() . ' ' . $elefe->getPrenom() . $suffix;
            $user->setEmail($email);
            $user->setFullname($userFullname);
            $user->setNom($userNom);
            $user->setPrenom($userPrenom);
            $user->setPassword($PasswordHasher->hashPassword($user, $password));
            $user->setUsername($username);
            $user->setRoles(['ROLE_ELEVE']);
            $entityManager->persist($user);
            $entityManager->flush();

            $elefe->setUser($user);
            $user->setEleves($elefe);

            $entityManager->persist($elefe);
            $entityManager->flush();

            return $this->redirectToRoute('app_eleves_controle_scolarite_non_presente', [], Response::HTTP_SEE_OTHER);
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
    public function edit(Request $request, Eleves $elefe, UserPasswordHasherInterface $PasswordHasher, ElevesRepository $elevesRepository, FraisScolairesRepository $fraisScolairesRepository, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
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

            $user = $elefe->getUser();
            if (!$user) {
                $suffix = substr(time(), -4);

                $user = new Users();
                $password = 'password';
                $email = "inscription@EMPT.edu";
                $userNom = $elefe->getNom();
                $userPrenom = $elefe->getPrenom();
                $userFullname = $elefe->getNom() . ' ' . $elefe->getPrenom();
                $username = $elefe->getNom() . ' ' . $elefe->getPrenom() . $suffix;
                $user->setEmail($email);
                $user->setFullname($userFullname);
                $user->setNom($userNom);
                $user->setPrenom($userPrenom);
                $user->setPassword($PasswordHasher->hashPassword($user, $password));
                $user->setUsername($username);
                $user->setRoles(['ROLE_ELEVE']);
                $entityManager->persist($user);
                $entityManager->flush();

                $elefe->setUser($user);
                $user->setEleves($elefe);
            }

            return $this->redirectToRoute('app_eleves_controle_scolarite_non_presente', [], Response::HTTP_SEE_OTHER);
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

    #[Route('/controle/scolarite/presence/1', name: 'app_eleves_controle_scolarite_non_presente', methods: ['GET', 'POST'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function controle(
        eleveService $eleveService,
        ElevesRepository $elevesRepository,
        EntityManagerInterface $entityManager,
        FraisScolairesRepository $fraisScolairesRepository
    ): Response {
        $elevesNonExonoresSansFraisScolarites = $elevesRepository->findElevesNonExonoresSansFraisScolarites();
        $entityManager->beginTransaction();

        try {
            foreach ($elevesNonExonoresSansFraisScolarites as $eleve) {
                $fraisScolaire = $fraisScolairesRepository->findOneFraisScolariteByNiveauAndStatut($eleve->getClasse()->getNiveau(), $eleve->getStatut());
                $resultats[] = $fraisScolaire;

                if ($fraisScolaire) {
                    $nouveauFraisScolarite = new FraisScolarites();
                    $nouveauFraisScolarite->setEleve($eleve);
                    $nouveauFraisScolarite->setInscription($fraisScolaire->getFraisInscription());
                    $nouveauFraisScolarite->setCarnet($fraisScolaire->getFraisCarnet());
                    $nouveauFraisScolarite->setTransfert($fraisScolaire->getFraisTransfert());
                    $nouveauFraisScolarite->setSeptembre($fraisScolaire->getSeptembre());
                    $nouveauFraisScolarite->setOctobre($fraisScolaire->getOctobre());
                    $nouveauFraisScolarite->setNovembre($fraisScolaire->getNovembre());
                    $nouveauFraisScolarite->setDecembre($fraisScolaire->getDecembre());
                    $nouveauFraisScolarite->setJanvier($fraisScolaire->getJanvier());
                    $nouveauFraisScolarite->setFevrier($fraisScolaire->getFevrier());
                    $nouveauFraisScolarite->setMars($fraisScolaire->getMars());
                    $nouveauFraisScolarite->setAvril($fraisScolaire->getAvril());
                    $nouveauFraisScolarite->setMai($fraisScolaire->getMai());
                    $nouveauFraisScolarite->setJuin($fraisScolaire->getJuin());
                    $nouveauFraisScolarite->setAutre($fraisScolaire->getAutres());
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

        return $this->redirectToRoute('app_eleves_controle_scolarite_presente_exonore', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/controle/scolarite/presence/2', name: 'app_eleves_controle_scolarite_presente_exonore', methods: ['GET', 'POST'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function controle2(
        eleveService $eleveService,
        ElevesRepository $elevesRepository,
        EntityManagerInterface $entityManager,
        FraisScolaritesRepository $fraisScolaritesRepository
    ): Response {
        $elevesExonoresFraisScolarites = $elevesRepository->findElevesExonoresAvecFraisScolarites();
        $entityManager->beginTransaction();

        try {
            foreach ($elevesExonoresFraisScolarites as $eleve) {

                $fraisScolaire = $fraisScolaritesRepository->findByEleve($eleve);


                if ($fraisScolaire) {
                    // Supprimer l'entité fraisScolaire
                    $entityManager->remove($fraisScolaire);
                    $entityManager->flush();
                }
            }

            $entityManager->flush();
            $entityManager->commit();
        } catch (\Exception $exception) {
            $entityManager->rollback();
            throw $exception;
        }

        return $this->redirectToRoute('app_eleves_controle_scolarite_presente_inactif', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/controle/scolarite/presence/3', name: 'app_eleves_controle_scolarite_presente_inactif', methods: ['GET', 'POST'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function controle3(
        eleveService $eleveService,
        ElevesRepository $elevesRepository,
        EntityManagerInterface $entityManager,
        FraisScolaritesRepository $fraisScolaritesRepository
    ): Response {
        $elevesInactifFraisScolarites = $elevesRepository->findElevesInactifAvecFraisScolarites();
        $entityManager->beginTransaction();
        try {
            foreach ($elevesInactifFraisScolarites as $eleve) {
                $fraisScolaire = $fraisScolaritesRepository->findByEleve($eleve);

                if ($fraisScolaire) {
                    $arriere = $fraisScolaire->getArrieres();
                    $inscription = $fraisScolaire->getInscription();
                    $carnet = $fraisScolaire->getCarnet();
                    $transfert = $fraisScolaire->getTransfert();
                    $sept = $fraisScolaire->getSeptembre();
                    $oct = $fraisScolaire->getOctobre();
                    $nov = $fraisScolaire->getNovembre();
                    $dec = $fraisScolaire->getDecembre();
                    $janv = $fraisScolaire->getJanvier();
                    $fev = $fraisScolaire->getFevrier();
                    $mars = $fraisScolaire->getMars();
                    $avr = $fraisScolaire->getAvril();
                    $mai = $fraisScolaire->getMai();
                    $juin = $fraisScolaire->getJuin();
                    $autre = $fraisScolaire->getAutre();
                    $total = $arriere + $inscription + $carnet + $transfert + $sept + $oct + $nov + $dec + $janv + $fev + $mars + $avr + $mai + $juin + $autre;

                    if ($total > 0) {
                        $abandon = new FraisScolaritesAbandon();
                        $abandon->setEleve($eleve);
                        $abandon->setArrieres($arriere);
                        $abandon->setInscription($inscription);
                        $abandon->setCarnet($carnet);
                        $abandon->setTransfert($transfert);
                        $abandon->setSeptembre($sept);
                        $abandon->setOctobre($oct);
                        $abandon->setNovembre($nov);
                        $abandon->setDecembre($dec);
                        $abandon->setJanvier($janv);
                        $abandon->setFevrier($fev);
                        $abandon->setMars($mars);
                        $abandon->setAvril($avr);
                        $abandon->setMai($mai);
                        $abandon->setJuin($juin);

                        $entityManager->persist($abandon);
                    }
                }
                //on supprime des frais scolaires l'élève ayant abandonné
                $entityManager->remove($fraisScolaire);
            }

            $entityManager->flush();
            $entityManager->commit();
        } catch (\Exception $exception) {
            $entityManager->rollback();
            throw $exception;
        }

        return $this->redirectToRoute('app_eleves_controle_scolarite_reintegre_actif', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/controle/scolarite/presence/4', name: 'app_eleves_controle_scolarite_reintegre_actif', methods: ['GET', 'POST'])]
    #[Cache(vary: ['Accept-Encoding'])] // Met en cache le rendu complet de la page
    public function controle4(
        eleveService $eleveService,
        ElevesRepository $elevesRepository,
        EntityManagerInterface $entityManager,
        FraisScolaritesRepository $fraisScolaritesRepository,
        FraisScolaritesAbandonRepository $fraisScolaritesAbandonRepository,
    ): Response {
        $elevesactifReintegrer = $elevesRepository->findElevesActifSansFraisScolarites();

        $entityManager->beginTransaction();
        try {
            foreach ($elevesactifReintegrer as $eleve) {
                $fraisScolaire = $fraisScolaritesAbandonRepository->findByEleve($eleve);

                if ($fraisScolaire) {
                    // Supprimer l'entité fraisScolaire
                    $entityManager->remove($fraisScolaire);
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
}
