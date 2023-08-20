<?php

namespace App\Form;

use App\Entity\Noms;
use App\Entity\Eleves;
use App\Entity\Cercles;
use App\Entity\Classes;
use App\Entity\Niveaux;
use App\Entity\Prenoms;
use App\Entity\Regions;
use App\Entity\Statuts;
use App\Form\MeresType;
use App\Form\PeresType;
use App\Entity\Communes;
use App\Entity\Telephones;
use App\Entity\Scolarites1;
use App\Entity\Scolarites2;
use App\Entity\Departements;
use App\Entity\LieuNaissances;
use App\Entity\Redoublements1;
use App\Entity\Redoublements2;
use App\Entity\Redoublements3;
use App\Entity\EcoleProvenances;
use Doctrine\ORM\EntityRepository;
use App\Repository\MeresRepository;
use App\Repository\PeresRepository;
use App\Repository\StatutsRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use App\Repository\Redoublements1Repository;
use App\Repository\Redoublements2Repository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


class ElevesType extends AbstractType
{
    private $pereExisteId;
    private $mereExisteId;
    public function __construct(
        private Redoublements2Repository $redoublements2Repository,
        private Redoublements1Repository $redoublements1Repository,
        private PeresRepository $peresRepository,
        private MeresRepository $meresRepository,
        private StatutsRepository $statutsRepository

    ) {
        $this->redoublements1Repository = $redoublements1Repository;
        $this->redoublements2Repository = $redoublements2Repository;
        $this->peresRepository = $peresRepository;
        $this->meresRepository = $meresRepository;
        $this->statutsRepository = $statutsRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFile', VichImageType::class, [
                'label' => "Photo d'identité",
                //'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/jpg',
                            'image/gif',
                            'image/png',
                        ]
                    ])
                ],
                'allow_delete' => true,
                'delete_label' => 'supprimer',
                'download_uri' => true,
                'download_label' => 'Télécharger',
                'image_uri'         => false,
                'asset_helper' => true,
            ])
            ->add('document', FileType::class, [
                'label' => 'Télécharger Documents (Fichier PDF/Word)',
                'mapped' => false,
                'required' => false,
                'multiple' => true,
                'constraints' => [
                    new All([
                        'constraints' => [
                            new File([
                                'maxSize' => '2048k',
                                'mimeTypes' => [
                                    'application/pdf',
                                    'application/x-pdf',
                                    'application/msword',
                                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                ],
                                'mimeTypesMessage' => 'Format valid valid PDF ou word',
                            ])
                        ]
                    ]),
                ]
            ])
            ->add('region', EntityType::class, [
                'class' => Regions::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->orderBy('r.designation', 'ASC');
                },
                'choice_label' => 'designation',
                'label' => 'Région',
                'placeholder' => 'Choisir la Région',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'select-region'
                ],
            ])
            ->add('niveau', EntityType::class, [
                'class' => Niveaux::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('n')
                        ->orderBy('n.id', 'ASC');
                },
                'choice_label' => 'designation',
                'label' => 'Niveau',
                'placeholder' => 'Choisir le Niveau',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'select-niveau'
                ],
            ])
            ->add('nom', EntityType::class, [
                'label' => 'Nom',
                'class' => Noms::class,
                'placeholder' => 'Entrer ou Choisir un Nom',
                'choice_label' => 'designation',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('n')
                        ->orderBy('n.designation', 'ASC');
                },
                'attr' => [
                    'class' => 'select-nomfamille'
                ],
                'error_bubbling' => false,
            ])
            ->add('prenom', EntityType::class, [
                'class' => Prenoms::class,
                'choice_label' => 'designation',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.designation', 'ASC');
                },
                'placeholder' => 'Entrer ou Choisir un prénom',
                'attr' => [
                    'class' => 'select-prenom'
                ],
                'error_bubbling' => false,
            ])
            ->add('sexe', ChoiceType::class, [
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'M' => 'Masculin',
                    'F' => 'Féminin'
                ],
                'label_attr' => [
                    'class' => 'radio-inline'
                ]
            ])
            ->add('numExtrait', TextType::class, [
                'attr' => ['placeholder' => "Numéro Extrait de Naissance"],
                'error_bubbling' => false,
            ])
            ->add('isAdmis', CheckboxType::class, [
                'label' => 'Admis',
                'required' => false,
            ])
            ->add('isActif', CheckboxType::class, [
                'label' => 'Actif',
                'required' => false,
            ])
            ->add('isHandicap', CheckboxType::class, [
                'label' => 'Handicapé(e)',
                'required' => false,
            ])
            ->add('natureHandicap', TextType::class, [
                'attr' => ['placeholder' => "Nature handicape"],
                'required' => false,
            ])
            ->add('statutFinance', ChoiceType::class, [
                'label' => 'Statut Financier',
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'privé(e)' => 'Privé(e)',
                    'boursier' => 'Boursier',
                    'exonoré(e)' => 'Exonoré(e)'
                ],
                'label_attr' => [
                    'class' => 'radio-inline'
                ]
            ])
            ->add('departement', EntityType::class, [
                'label' => 'Département',
                'class' => Departements::class,
                'choice_label' => 'designation',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.designation', 'ASC');
                },
                'placeholder' => 'Entrer ou Choisir un département',
                'attr' => [
                    'class' => 'select-departement'
                ],
                'error_bubbling' => false,
            ])
            ->add('adresse', TextareaType::class, [
                'attr' => ['placeholder' => "Adresse du domicile"],
                'required' => false,
            ])
            ->add('santes', CollectionType::class, [
                'entry_type' => SantesType::class,
                'entry_options' => ['label' => true],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'error_bubbling' => false,
            ])
            ->add('departs', CollectionType::class, [
                'entry_type' => DepartsType::class,
                'entry_options' => ['label' => true],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'error_bubbling' => false,
            ]);

        $builder->get('niveau')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $data = $event->getData();
                $this->addClassesField($form->getParent(), $form->getData());
                $this->addDateNaissanceField($form->getParent(), $form->getData());
                $this->addDateRecrutementField($form->getParent(), $form->getData());
                $this->addScolarites1Field($form->getParent(), $form->getData());
                $isNewRegistration = !$form->getParent()->getData()->getId(); // Assuming getId() returns the ID of the entity

                $this->addStatutsField($form->getParent(), $form->getData(), $isNewRegistration);
            }
        );

        $builder->get('region')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $data = $form->getData();
                $this->addCerclesField($form->getParent(), $form->getData());
            }
        );

        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
                $data = $event->getData();
                /**@LieuNaissances $lieuNaissance */
                $lieuNaissance = $data->getLieuNaissance();
                $form = $event->getForm();
                if ($lieuNaissance) {
                    $commune = $lieuNaissance->getCommune();
                    $cercle = $commune->getCercle();
                    $region = $cercle->getRegion();
                    $this->addCerclesField($form, $region);
                    $this->addCommunesField($form, $cercle);
                    $this->addLieuNaissanceField($form, $commune);
                    $form->get('region')->setData($region);
                    $form->get('cercle')->setData($cercle);
                    $form->get('commune')->setData($commune);
                } else {
                    $this->addCerclesField($form, null);
                    $this->addCommunesField($form, null);
                    $this->addLieuNaissanceField($form, null);
                }
            }
        );

        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
                $data = $event->getData();
                /**@var Classes $classe */
                $classe = $data->getClasse();
                $form = $event->getForm();
                if ($classe) {
                    $niveau = $classe->getNiveau();
                    $this->addClassesField($form, $niveau);
                    $form->get('niveau')->setData($niveau);
                } else {
                    $this->addClassesField($form, null);
                }
            }
        );

        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
                $data = $event->getData();
                /**@var Statuts $statut */
                $statut = $data->getStatut();
                $form = $event->getForm();
                if ($statut) {
                    $niveau = $statut->getNiveau();
                    $isNewRegistration = $form ? !$form : true;

                    $this->addStatutsField($form, $niveau, $isNewRegistration);
                    $form->get('niveau')->setData($niveau);
                } else {
                    $isNewRegistration = $form ? !$form : true;
                    $this->addStatutsField($form, null, $isNewRegistration);
                }
            }
        );

        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
                $data = $event->getData();
                /**@var Redoublements3 $redoublements3 */
                $redoublements3 = $data->getRedoublement3();
                $form = $event->getForm();

                if ($redoublements3) {
                    $redoublement2 = $redoublements3->getRedoublement2();
                    $redoublement1 = $redoublement2->getRedoublement1();
                    $scolarite2 = $redoublement1->getScolarite2();
                    $scolarite1 = $scolarite2->getScolarite1();
                    $niveau = $scolarite1->getNiveau();
                    $this->addDateNaissanceField($form, $niveau);
                    $this->addDateRecrutementField($form, $niveau);
                    $this->addScolarites1Field($form, $niveau);
                    $this->addScolarites2Field($form, $scolarite1);
                    $this->addRedoublement1Field($form, $scolarite2);
                    $this->addRedoublement2Field($form, $redoublement1);
                    $this->addRedoublement3Field($form, $redoublement2);
                    $form->get('niveau')->setData($niveau);
                    $form->get('scolarite1')->setData($scolarite1);
                    $form->get('scolarite2')->setData($scolarite2);
                    $form->get('redoublement1')->setData($redoublement1);
                    $form->get('redoublement2')->setData($redoublement2);
                } else {
                    /**@var Redoublements2 $redoublements2 */
                    $redoublements2 = $data->getRedoublement2();
                    $form = $event->getForm();
                    if ($redoublements2) {
                        $redoublement1 = $redoublements2->getRedoublement1();
                        $scolarite2 = $redoublement1->getScolarite2();
                        $scolarite1 = $scolarite2->getScolarite1();
                        $niveau = $scolarite1->getNiveau();
                        $this->addDateNaissanceField($form, $niveau);
                        $this->addDateRecrutementField($form, $niveau);
                        $this->addScolarites1Field($form, $niveau);
                        $this->addScolarites2Field($form, $scolarite1);
                        $this->addRedoublement1Field($form, $scolarite2);
                        $this->addRedoublement2Field($form, $redoublement1);
                        $this->addRedoublement3Field($form, $redoublements2);
                        $form->get('niveau')->setData($niveau);
                        $form->get('scolarite1')->setData($scolarite1);
                        $form->get('scolarite2')->setData($scolarite2);
                        $form->get('redoublement1')->setData($redoublement1);
                    } else {
                        /**@var Redoublements1 $redoublements1 */
                        $redoublements1 = $data->getRedoublement1();
                        $form = $event->getForm();
                        if ($redoublements1) {
                            $scolarite2 = $redoublements1->getScolarite2();
                            $scolarite1 = $scolarite2->getScolarite1();
                            $niveau = $scolarite1->getNiveau();
                            $this->addDateNaissanceField($form, $niveau);
                            $this->addDateRecrutementField($form, $niveau);
                            $this->addScolarites1Field($form, $niveau);
                            $this->addScolarites2Field($form, $scolarite1);
                            $this->addRedoublement1Field($form, $scolarite2);
                            $this->addRedoublement2Field($form, $redoublements1);
                            $this->addRedoublement3Field($form, $redoublements2);
                            $form->get('niveau')->setData($niveau);
                            $form->get('scolarite1')->setData($scolarite1);
                            $form->get('scolarite2')->setData($scolarite2);
                        } else {
                            /**@var Scolarites2 $scolarites2 */
                            $scolarites2 = $data->getScolarite2();
                            $form = $event->getForm();
                            if ($scolarites2) {
                                $scolarite1 = $scolarites2->getScolarite1();
                                $niveau = $scolarite1->getNiveau();
                                $this->addDateNaissanceField($form, $niveau);
                                $this->addDateRecrutementField($form, $niveau);
                                $this->addScolarites1Field($form, $niveau);
                                $this->addScolarites2Field($form, $scolarite1);
                                $this->addRedoublement1Field($form, $scolarites2);
                                $this->addRedoublement2Field($form, $redoublements1);
                                $this->addRedoublement3Field($form, $redoublements2);
                                $form->get('niveau')->setData($niveau);
                                $form->get('scolarite1')->setData($scolarite1);
                            } else {
                                /**@var Scolarites1 $scolarites1 */
                                $scolarites1 = $data->getScolarite1();
                                $form = $event->getForm();
                                if ($scolarites2) {
                                    $niveau = $scolarites1->getNiveau();
                                    $this->addDateNaissanceField($form, $niveau);
                                    $this->addDateRecrutementField($form, $niveau);
                                    $this->addScolarites1Field($form, $niveau);
                                    $this->addScolarites2Field($form, $scolarites1);
                                    $this->addRedoublement1Field($form, $scolarites2);
                                    $this->addRedoublement2Field($form, $redoublements1);
                                    $this->addRedoublement3Field($form, $redoublements2);
                                    $form->get('niveau')->setData($niveau);
                                } else {
                                    $this->addDateNaissanceField($form, null);
                                    $this->addDateRecrutementField($form, null);
                                    $this->addScolarites1Field($form, null);
                                    $this->addScolarites2Field($form, null);
                                    $this->addRedoublement1Field($form, null);
                                    $this->addRedoublement2Field($form, null);
                                    $this->addRedoublement3Field($form, null);
                                }
                            }
                        }
                    }
                }
            }
        );
    }


    public function addClassesField(FormInterface $form, ?Niveaux $niveaux)
    {
        $form->add('classe', EntityType::class, [
            'class' => Classes::class,
            'choice_label' => 'designation',
            'choices' => $niveaux ? $niveaux->getClasses() : [],
            'label' => 'Classe',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->orderBy('c.designation', 'ASC');
            },
            'placeholder' => $niveaux ? 'Sélectionnez la Classe' : 'Sélectionnez le niveau',
            'attr' => [
                'class' => 'select-classes'
            ],
            'error_bubbling' => false,
        ]);
    }

    public function addStatutsField(FormInterface $form, ?Niveaux $niveaux, bool $isNewRegistration)
    {
        $statutsForRegistration = $this->statutsRepository->findStatutsForNlEnregistrement($niveaux);
        if ($isNewRegistration) {
            $form->add('statut', EntityType::class, [
                'label' => 'Statut',
                'class' => Statuts::class,
                'choices' => $statutsForRegistration ? $statutsForRegistration : [],
                'placeholder' => 'Entrer ou Choisir un statut',
                'choice_label' => 'designation',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.designation', 'ASC');
                },
                'attr' => [
                    'class' => 'select-statut'
                ],
                'error_bubbling' => false,
            ]);
        } else {
            $form->add('statut', EntityType::class, [
                'label' => 'Statut',
                'class' => Statuts::class,
                'choices' => $niveaux ? $niveaux->getStatuts() : [],
                'placeholder' => 'Entrer ou Choisir un statut',
                'choice_label' => 'designation',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.designation', 'ASC');
                },
                'attr' => [
                    'class' => 'select-statut'
                ],
                'error_bubbling' => false,
            ]);
        }
    }

    private function addDateNaissanceField(FormInterface $form, ?Niveaux $niveau)
    {
        $cycle = $niveau ? $niveau->getCycle() : [];
        $enseignement = $cycle ? $cycle->getEnseignement() : [];
        $ecole = $enseignement ? $enseignement->getEtablissement() : [];
        if (!$niveau) {
            $form->add('dateNaissance', DateType::class, [
                'label' => 'Date de Naissance',
                'widget' => 'single_text',
                'auto_initialize' => false,
            ])
                ->add('dateExtrait', DateType::class, [
                    'label' => 'Date / Extrait',
                    'widget' => 'single_text',
                    'auto_initialize' => false,
                ])
                ->add('ecoleAnDernier', EntityType::class, [
                    'class' => EcoleProvenances::class,
                    'choice_label' => 'designation',
                    'label' => 'Ecole AN Dernier',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('e')
                            ->orderBy('e.designation', 'ASC');
                    },
                    'placeholder' => "Sélectionnez l'école",
                    'attr' => [
                        'class' => 'select-ecole',
                    ],
                    'required' => false,
                    'error_bubbling' => false,
                ])
                ->add('ecoleRecrutement', EntityType::class, [
                    'class' => EcoleProvenances::class,
                    'choice_label' => 'designation',
                    'label' => 'Ecole de Recrutement',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('e')
                            ->orderBy('e.designation', 'ASC');
                    },
                    'placeholder' => "Sélectionnez l'école",
                    'attr' => [
                        'class' => 'select-ecole',
                    ],
                    'required' => false,
                    'error_bubbling' => false,
                ]);
        } else {
            $designation = $niveau->getDesignation();
            if ($designation == "Petite Section") {
                $form->add('dateNaissance', DateType::class, [
                    'label' => 'Date de Naissance',
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'attr' => [
                        'min' => (new \DateTime('now -1460 days'))->format('Y-m-d'),
                        'max' => (new \DateTime('now -1095 days'))->format('Y-m-d')
                    ],
                    'auto_initialize' => false,
                    'constraints' => [
                        new NotBlank(),
                    ],
                ])
                    ->add('dateExtrait', DateType::class, [
                        'label' => 'Date / Extrait',
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'attr' => [
                            'min' => (new \DateTime('now -1460 days'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -1 days'))->format('Y-m-d')
                        ],
                        'auto_initialize' => false,
                        'constraints' => [
                            new NotBlank,
                            //new Constraints\DateTime(),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $dateNaissance = $context->getRoot()->getData()->getDateNaissance();
                                $dateExtrait = $object;

                                if (is_a($dateNaissance, \DateTime::class) && is_a($dateExtrait, \DateTime::class)) {
                                    if ($dateExtrait->format('U') - $dateNaissance->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'extrait Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                    ->add('ecoleAnDernier', EntityType::class, [
                        'class' => EcoleProvenances::class,
                        'choice_label' => 'designation',
                        'label' => 'Ecole AN Dernier',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->orderBy('e.designation', 'ASC');
                        },
                        'placeholder' => "Sélectionnez l'école",
                        'attr' => [
                            'class' => 'select-ecole',
                            'disabled' => 'disabled',
                        ],
                        'required' => false,
                        'error_bubbling' => false,
                    ])
                    ->add('ecoleRecrutement', EntityType::class, [
                        'class' => EcoleProvenances::class,
                        'choice_label' => 'designation',

                        'label' => 'Ecole de Recrutement',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->orderBy('e.designation', 'ASC');
                        },
                        'placeholder' => "Sélectionnez l'école",
                        'attr' => [
                            'class' => 'select-ecole'
                        ],
                        'error_bubbling' => false,
                    ]);
            } elseif ($designation == "Moyenne Section") {
                $form->add('dateNaissance', DateType::class, [
                    'label' => 'Date de Naissance',
                    'input' => 'datetime',
                    //'html5' => false,
                    'widget' => 'single_text',
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'attr' => [
                        'min' => (new \DateTime('now -1825 days'))->format('Y-m-d'),
                        'max' => (new \DateTime('now -1460 days'))->format('Y-m-d')
                    ],
                    'auto_initialize' => false,
                ])
                    ->add('dateExtrait', DateType::class, [
                        'label' => 'Date / Extrait',
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'attr' => [
                            'min' => (new \DateTime('now -1825 days'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -1 days'))->format('Y-m-d')
                        ],
                        'auto_initialize' => false,
                        'constraints' => [
                            new NotBlank,
                            //new Constraints\DateTime(),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $dateNaissance = $context->getRoot()->getData()->getDateNaissance();
                                $dateExtrait = $object;

                                if (is_a($dateNaissance, \DateTime::class) && is_a($dateExtrait, \DateTime::class)) {
                                    if ($dateExtrait->format('U') - $dateNaissance->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'extrait Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                    ->add('ecoleAnDernier', EntityType::class, [
                        'class' => EcoleProvenances::class,
                        'choice_label' => 'designation',
                        'label' => 'Ecole AN Dernier',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->orderBy('e.designation', 'ASC');
                        },
                        'placeholder' => "Sélectionnez l'école",
                        'attr' => [
                            'class' => 'select-ecole',
                            'disabled' => 'disabled',
                        ],
                        'required' => false,
                        'error_bubbling' => false,
                    ])
                    ->add('ecoleRecrutement', EntityType::class, [
                        'class' => EcoleProvenances::class,
                        'choice_label' => 'designation',

                        'label' => 'Ecole de Recrutement',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->orderBy('e.designation', 'ASC');
                        },
                        'placeholder' => "Sélectionnez l'école",
                        'attr' => [
                            'class' => 'select-ecole'
                        ],
                        'error_bubbling' => false,
                    ]);
            } elseif ($designation == "Grande Section") {
                $form->add('dateNaissance', DateType::class, [
                    'label' => 'Date de Naissance',
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'attr' => [
                        'min' => (new \DateTime('now -2190 days'))->format('Y-m-d'),
                        'max' => (new \DateTime('now -1460 days'))->format('Y-m-d')
                    ],
                    'auto_initialize' => false,
                ])
                    ->add('dateExtrait', DateType::class, [
                        'label' => 'Date / Extrait',
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'attr' => [
                            'min' => (new \DateTime('now -2190 days'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -1 days'))->format('Y-m-d')
                        ],
                        'auto_initialize' => false,
                        'constraints' => [
                            new NotBlank,
                            //new Constraints\DateTime(),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $dateNaissance = $context->getRoot()->getData()->getDateNaissance();
                                $dateExtrait = $object;

                                if (is_a($dateNaissance, \DateTime::class) && is_a($dateExtrait, \DateTime::class)) {
                                    if ($dateExtrait->format('U') - $dateNaissance->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'extrait Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                    ->add('ecoleAnDernier', EntityType::class, [
                        'class' => EcoleProvenances::class,
                        'choice_label' => 'designation',
                        'label' => 'Ecole AN Dernier',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->orderBy('e.designation', 'ASC');
                        },
                        'placeholder' => "Sélectionnez l'école",
                        'attr' => [
                            'class' => 'select-ecole',
                            'disabled' => 'disabled',
                        ],
                        'required' => false,
                        'error_bubbling' => false,
                    ])
                    ->add('ecoleRecrutement', EntityType::class, [
                        'class' => EcoleProvenances::class,
                        'choice_label' => 'designation',

                        'label' => 'Ecole de Recrutement',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->orderBy('e.designation', 'ASC');
                        },
                        'placeholder' => "Sélectionnez l'école",
                        'attr' => [
                            'class' => 'select-ecole'
                        ],
                        'error_bubbling' => false,
                    ]);
            } elseif ($designation == "1ère Année") {
                $form->add('dateNaissance', DateType::class, [
                    'label' => 'Date de Naissance',
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'attr' => [
                        'min' => (new \DateTime('now -2920 days'))->format('Y-m-d'),
                        'max' => (new \DateTime('now -1825 days'))->format('Y-m-d')
                    ],
                    'auto_initialize' => false,
                ])
                    ->add('dateExtrait', DateType::class, [
                        'label' => 'Date / Extrait',
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'attr' => [
                            'min' => (new \DateTime('now -2920 days'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -1 days'))->format('Y-m-d')
                        ],
                        'auto_initialize' => false,
                        'constraints' => [
                            new NotBlank,
                            //new Constraints\DateTime(),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $dateNaissance = $context->getRoot()->getData()->getDateNaissance();
                                $dateExtrait = $object;

                                if (is_a($dateNaissance, \DateTime::class) && is_a($dateExtrait, \DateTime::class)) {
                                    if ($dateExtrait->format('U') - $dateNaissance->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'extrait Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                    ->add('ecoleAnDernier', EntityType::class, [
                        'class' => EcoleProvenances::class,
                        'choice_label' => 'designation',
                        'label' => 'Ecole AN Dernier',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->orderBy('e.designation', 'ASC');
                        },
                        'placeholder' => "Sélectionnez l'école",
                        'attr' => [
                            'class' => 'select-ecole',
                            'disabled' => 'disabled',
                        ],
                        'required' => false,
                        'error_bubbling' => false,
                    ])
                    ->add('ecoleRecrutement', EntityType::class, [
                        'class' => EcoleProvenances::class,
                        'choice_label' => 'designation',

                        'label' => 'Ecole de Recrutement',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->orderBy('e.designation', 'ASC');
                        },
                        'placeholder' => "Sélectionnez l'école",
                        'attr' => [
                            'class' => 'select-ecole'
                        ],
                        'error_bubbling' => false,
                    ]);
            } elseif ($designation == "2ème Année") {
                $form->add('dateNaissance', DateType::class, [
                    'label' => 'Date de Naissance',
                    'input' => 'datetime',
                    'widget' => 'single_text',

                    'constraints' => [
                        new NotBlank(),
                    ],                    'attr' => [
                        'min' => (new \DateTime('now -3285 days'))->format('Y-m-d'),
                        'max' => (new \DateTime('now -2190 days'))->format('Y-m-d')
                    ],
                    'auto_initialize' => false,
                ])
                    ->add('dateExtrait', DateType::class, [
                        'label' => 'Date / Extrait',
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'attr' => [
                            'min' => (new \DateTime('now -3285 days'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -1 days'))->format('Y-m-d')
                        ],
                        'auto_initialize' => false,
                        'constraints' => [
                            //new Constraints\DateTime(),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $dateNaissance = $context->getRoot()->getData()->getDateNaissance();
                                $dateExtrait = $object;

                                if (is_a($dateNaissance, \DateTime::class) && is_a($dateExtrait, \DateTime::class)) {
                                    if ($dateExtrait->format('U') - $dateNaissance->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'extrait Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                    ->add('ecoleAnDernier', EntityType::class, [
                        'class' => EcoleProvenances::class,
                        'choice_label' => 'designation',
                        'label' => 'Ecole AN Dernier',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->orderBy('e.designation', 'ASC');
                        },
                        'placeholder' => "Sélectionnez l'école",
                        'attr' => [
                            'class' => 'select-ecole',
                        ],
                        'error_bubbling' => false,
                    ])
                    ->add('ecoleRecrutement', EntityType::class, [
                        'class' => EcoleProvenances::class,
                        'choice_label' => 'designation',

                        'label' => 'Ecole de Recrutement',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->orderBy('e.designation', 'ASC');
                        },
                        'placeholder' => "Sélectionnez l'école",
                        'attr' => [
                            'class' => 'select-ecole'
                        ],
                        'error_bubbling' => false,
                    ]);
            } elseif ($designation == "3ème Année") {
                $form->add('dateNaissance', DateType::class, [
                    'label' => 'Date de Naissance',
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'attr' => [
                        'min' => (new \DateTime('now -3650 days'))->format('Y-m-d'),
                        'max' => (new \DateTime('now -2555 days'))->format('Y-m-d')
                    ],
                    'auto_initialize' => false,
                ])
                    ->add('dateExtrait', DateType::class, [
                        'label' => 'Date / Extrait',
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'attr' => [
                            'min' => (new \DateTime('now -3650 days'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -1 days'))->format('Y-m-d')
                        ],
                        'auto_initialize' => false,
                        'constraints' => [
                            //new Constraints\DateTime(),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $dateNaissance = $context->getRoot()->getData()->getDateNaissance();
                                $dateExtrait = $object;

                                if (is_a($dateNaissance, \DateTime::class) && is_a($dateExtrait, \DateTime::class)) {
                                    if ($dateExtrait->format('U') - $dateNaissance->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'extrait Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                    ->add('ecoleAnDernier', EntityType::class, [
                        'class' => EcoleProvenances::class,
                        'choice_label' => 'designation',
                        'label' => 'Ecole AN Dernier',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->orderBy('e.designation', 'ASC');
                        },
                        'placeholder' => "Sélectionnez l'école",
                        'attr' => [
                            'class' => 'select-ecole',
                        ],
                        'error_bubbling' => false,
                    ])
                    ->add('ecoleRecrutement', EntityType::class, [
                        'class' => EcoleProvenances::class,
                        'choice_label' => 'designation',

                        'label' => 'Ecole de Recrutement',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->orderBy('e.designation', 'ASC');
                        },
                        'placeholder' => "Sélectionnez l'école",
                        'attr' => [
                            'class' => 'select-ecole'
                        ],
                        'error_bubbling' => false,
                    ]);
            } elseif ($designation == "4ème Année") {
                $form->add('dateNaissance', DateType::class, [
                    'label' => 'Date de Naissance',
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'attr' => [
                        'min' => (new \DateTime('now -4015 days'))->format('Y-m-d'),
                        'max' => (new \DateTime('now -2925 days'))->format('Y-m-d')
                    ],
                    'auto_initialize' => false,
                ])
                    ->add('dateExtrait', DateType::class, [
                        'label' => 'Date / Extrait',
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'attr' => [
                            'min' => (new \DateTime('now -4015 days'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -1 days'))->format('Y-m-d')
                        ],
                        'auto_initialize' => false,
                        'constraints' => [
                            //new Constraints\DateTime(),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $dateNaissance = $context->getRoot()->getData()->getDateNaissance();
                                $dateExtrait = $object;

                                if (is_a($dateNaissance, \DateTime::class) && is_a($dateExtrait, \DateTime::class)) {
                                    if ($dateExtrait->format('U') - $dateNaissance->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'extrait Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                    ->add('ecoleAnDernier', EntityType::class, [
                        'class' => EcoleProvenances::class,
                        'choice_label' => 'designation',
                        'label' => 'Ecole AN Dernier',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->orderBy('e.designation', 'ASC');
                        },
                        'placeholder' => "Sélectionnez l'école",
                        'attr' => [
                            'class' => 'select-ecole',
                        ],
                        'error_bubbling' => false,
                    ])
                    ->add('ecoleRecrutement', EntityType::class, [
                        'class' => EcoleProvenances::class,
                        'choice_label' => 'designation',

                        'label' => 'Ecole de Recrutement',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->orderBy('e.designation', 'ASC');
                        },
                        'placeholder' => "Sélectionnez l'école",
                        'attr' => [
                            'class' => 'select-ecole'
                        ],
                        'error_bubbling' => false,
                    ]);
            } elseif ($designation == "5ème Année") {
                $form->add('dateNaissance', DateType::class, [
                    'label' => 'Date de Naissance',
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'attr' => [
                        'min' => (new \DateTime('now -4380 days'))->format('Y-m-d'),
                        'max' => (new \DateTime('now -3285 days'))->format('Y-m-d')
                    ],
                    'auto_initialize' => false,
                ])
                    ->add('dateExtrait', DateType::class, [
                        'label' => 'Date / Extrait',
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'attr' => [
                            'min' => (new \DateTime('now -4380 days'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -1 days'))->format('Y-m-d')
                        ],
                        'auto_initialize' => false,
                        'constraints' => [
                            //new Constraints\DateTime(),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $dateNaissance = $context->getRoot()->getData()->getDateNaissance();
                                $dateExtrait = $object;

                                if (is_a($dateNaissance, \DateTime::class) && is_a($dateExtrait, \DateTime::class)) {
                                    if ($dateExtrait->format('U') - $dateNaissance->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'extrait Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                    ->add('ecoleAnDernier', EntityType::class, [
                        'class' => EcoleProvenances::class,
                        'choice_label' => 'designation',
                        'label' => 'Ecole AN Dernier',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->orderBy('e.designation', 'ASC');
                        },
                        'placeholder' => "Sélectionnez l'école",
                        'attr' => [
                            'class' => 'select-ecole',
                        ],
                        'error_bubbling' => false,
                    ])
                    ->add('ecoleRecrutement', EntityType::class, [
                        'class' => EcoleProvenances::class,
                        'choice_label' => 'designation',

                        'label' => 'Ecole de Recrutement',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->orderBy('e.designation', 'ASC');
                        },
                        'placeholder' => "Sélectionnez l'école",
                        'attr' => [
                            'class' => 'select-ecole'
                        ],
                        'error_bubbling' => false,
                    ]);
            } elseif ($designation == "6ème Année") {
                $form->add('dateNaissance', DateType::class, [
                    'label' => 'Date de Naissance',
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'attr' => [
                        'min' => (new \DateTime('now -4745 days'))->format('Y-m-d'),
                        'max' => (new \DateTime('now -3650 days'))->format('Y-m-d')
                    ],
                    'auto_initialize' => false,
                ])
                    ->add('dateExtrait', DateType::class, [
                        'label' => 'Date / Extrait',
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'attr' => [
                            'min' => (new \DateTime('now -4745 days'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -1 days'))->format('Y-m-d')
                        ],
                        'auto_initialize' => false,
                        'constraints' => [
                            //new Constraints\DateTime(),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $dateNaissance = $context->getRoot()->getData()->getDateNaissance();
                                $dateExtrait = $object;

                                if (is_a($dateNaissance, \DateTime::class) && is_a($dateExtrait, \DateTime::class)) {
                                    if ($dateExtrait->format('U') - $dateNaissance->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'extrait Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                    ->add('ecoleAnDernier', EntityType::class, [
                        'class' => EcoleProvenances::class,
                        'choice_label' => 'designation',
                        'label' => 'Ecole AN Dernier',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->orderBy('e.designation', 'ASC');
                        },
                        'placeholder' => "Sélectionnez l'école",
                        'attr' => [
                            'class' => 'select-ecole',
                        ],
                        'error_bubbling' => false,
                    ])
                    ->add('ecoleRecrutement', EntityType::class, [
                        'class' => EcoleProvenances::class,
                        'choice_label' => 'designation',

                        'label' => 'Ecole de Recrutement',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->orderBy('e.designation', 'ASC');
                        },
                        'placeholder' => "Sélectionnez l'école",
                        'attr' => [
                            'class' => 'select-ecole'
                        ],
                        'error_bubbling' => false,
                    ]);
            } elseif ($designation == "7ème Année") {
                $form->add('dateNaissance', DateType::class, [
                    'label' => 'Date de Naissance',
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'attr' => [
                        'min' => (new \DateTime('now -5110 days'))->format('Y-m-d'),
                        'max' => (new \DateTime('now -4015 days'))->format('Y-m-d')
                    ],
                    'auto_initialize' => false,
                ])
                    ->add('dateExtrait', DateType::class, [
                        'label' => 'Date / Extrait',
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'attr' => [
                            'min' => (new \DateTime('now -5110 days'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -1 days'))->format('Y-m-d')
                        ],
                        'auto_initialize' => false,
                        'constraints' => [
                            //new Constraints\DateTime(),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $dateNaissance = $context->getRoot()->getData()->getDateNaissance();
                                $dateExtrait = $object;

                                if (is_a($dateNaissance, \DateTime::class) && is_a($dateExtrait, \DateTime::class)) {
                                    if ($dateExtrait->format('U') - $dateNaissance->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'extrait Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                    ->add('ecoleAnDernier', EntityType::class, [
                        'class' => EcoleProvenances::class,
                        'choice_label' => 'designation',
                        'label' => 'Ecole AN Dernier',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->orderBy('e.designation', 'ASC');
                        },
                        'placeholder' => "Sélectionnez l'école",
                        'attr' => [
                            'class' => 'select-ecole',
                        ],
                        'error_bubbling' => false,
                    ])
                    ->add('ecoleRecrutement', EntityType::class, [
                        'class' => EcoleProvenances::class,
                        'choice_label' => 'designation',

                        'label' => 'Ecole de Recrutement',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->orderBy('e.designation', 'ASC');
                        },
                        'placeholder' => "Sélectionnez l'école",
                        'attr' => [
                            'class' => 'select-ecole'
                        ],
                        'error_bubbling' => false,
                    ]);
            } elseif ($designation == "8ème Année") {
                $form->add('dateNaissance', DateType::class, [
                    'label' => 'Date de Naissance',
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'attr' => [
                        'min' => (new \DateTime('now -5475 days'))->format('Y-m-d'),
                        'max' => (new \DateTime('now -4380 days'))->format('Y-m-d')
                    ],
                    'auto_initialize' => false,
                ])
                    ->add('dateExtrait', DateType::class, [
                        'label' => 'Date / Extrait',
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'attr' => [
                            'min' => (new \DateTime('now -5475 days'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -1 days'))->format('Y-m-d')
                        ],
                        'auto_initialize' => false,
                        'constraints' => [
                            //new Constraints\DateTime(),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $dateNaissance = $context->getRoot()->getData()->getDateNaissance();
                                $dateExtrait = $object;

                                if (is_a($dateNaissance, \DateTime::class) && is_a($dateExtrait, \DateTime::class)) {
                                    if ($dateExtrait->format('U') - $dateNaissance->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'extrait Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                    ->add('ecoleAnDernier', EntityType::class, [
                        'class' => EcoleProvenances::class,
                        'choice_label' => 'designation',
                        'label' => 'Ecole AN Dernier',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->orderBy('e.designation', 'ASC');
                        },
                        'placeholder' => "Sélectionnez l'école",
                        'attr' => [
                            'class' => 'select-ecole',
                        ],
                        'error_bubbling' => false,
                    ])
                    ->add('ecoleRecrutement', EntityType::class, [
                        'class' => EcoleProvenances::class,
                        'choice_label' => 'designation',

                        'label' => 'Ecole de Recrutement',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->orderBy('e.designation', 'ASC');
                        },
                        'placeholder' => "Sélectionnez l'école",
                        'attr' => [
                            'class' => 'select-ecole'
                        ],
                        'error_bubbling' => false,
                    ]);
            } elseif ($designation == "9ème Année") {
                $form->add('dateNaissance', DateType::class, [
                    'label' => 'Date de Naissance',
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'attr' => [
                        'min' => (new \DateTime('now -5840 days'))->format('Y-m-d'),
                        'max' => (new \DateTime('now -4745 days'))->format('Y-m-d')
                    ],
                    'auto_initialize' => false,
                ])
                    ->add('dateExtrait', DateType::class, [
                        'label' => 'Date / Extrait',
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'attr' => [
                            'min' => (new \DateTime('now -5840 days'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -1 days'))->format('Y-m-d')
                        ],
                        'auto_initialize' => false,
                        'constraints' => [
                            //new Constraints\DateTime(),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $dateNaissance = $context->getRoot()->getData()->getDateNaissance();
                                $dateExtrait = $object;

                                if (is_a($dateNaissance, \DateTime::class) && is_a($dateExtrait, \DateTime::class)) {
                                    if ($dateExtrait->format('U') - $dateNaissance->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'extrait Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                    ->add('ecoleAnDernier', EntityType::class, [
                        'class' => EcoleProvenances::class,
                        'choice_label' => 'designation',
                        'label' => 'Ecole AN Dernier',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->orderBy('e.designation', 'ASC');
                        },
                        'placeholder' => "Sélectionnez l'école",
                        'attr' => [
                            'class' => 'select-ecole',
                        ],
                        'error_bubbling' => false,
                    ])
                    ->add('ecoleRecrutement', EntityType::class, [
                        'class' => EcoleProvenances::class,
                        'choice_label' => 'designation',

                        'label' => 'Ecole de Recrutement',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->orderBy('e.designation', 'ASC');
                        },
                        'placeholder' => "Sélectionnez l'école",
                        'attr' => [
                            'class' => 'select-ecole'
                        ],
                        'error_bubbling' => false,
                    ]);
            } elseif ($designation == "10ème Année") {
                $form->add('dateNaissance', DateType::class, [
                    'label' => 'Date de Naissance',
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'attr' => [
                        'min' => (new \DateTime('now -6205 days'))->format('Y-m-d'),
                        'max' => (new \DateTime('now -5110 days'))->format('Y-m-d')
                    ],
                    'auto_initialize' => false,
                ])
                    ->add('dateExtrait', DateType::class, [
                        'label' => 'Date / Extrait',
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'attr' => [
                            'min' => (new \DateTime('now -6205 days'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -1 days'))->format('Y-m-d')
                        ],
                        'auto_initialize' => false,
                        'constraints' => [
                            //new Constraints\DateTime(),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $dateNaissance = $context->getRoot()->getData()->getDateNaissance();
                                $dateExtrait = $object;

                                if (is_a($dateNaissance, \DateTime::class) && is_a($dateExtrait, \DateTime::class)) {
                                    if ($dateExtrait->format('U') - $dateNaissance->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'extrait Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                    ->add('ecoleAnDernier', EntityType::class, [
                        'class' => EcoleProvenances::class,
                        'choice_label' => 'designation',
                        'label' => 'Ecole AN Dernier',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->orderBy('e.designation', 'ASC');
                        },
                        'placeholder' => "Sélectionnez l'école",
                        'attr' => [
                            'class' => 'select-ecole',
                        ],
                        'error_bubbling' => false,
                    ])
                    ->add('ecoleRecrutement', EntityType::class, [
                        'class' => EcoleProvenances::class,
                        'choice_label' => 'designation',

                        'label' => 'Ecole de Recrutement',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->orderBy('e.designation', 'ASC');
                        },
                        'placeholder' => "Sélectionnez l'école",
                        'attr' => [
                            'class' => 'select-ecole'
                        ],
                        'error_bubbling' => false,
                    ]);
            } elseif ($designation == "11ème Année") {
                $form->add('dateNaissance', DateType::class, [
                    'label' => 'Date de Naissance',
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'attr' => [
                        'min' => (new \DateTime('now -6570 days'))->format('Y-m-d'),
                        'max' => (new \DateTime('now -5475 days'))->format('Y-m-d')
                    ],
                    'auto_initialize' => false,
                ])
                    ->add('dateExtrait', DateType::class, [
                        'label' => 'Date / Extrait',
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'attr' => [
                            'min' => (new \DateTime('now -6570 days'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -1 days'))->format('Y-m-d')
                        ],
                        'auto_initialize' => false,
                        'constraints' => [
                            //new Constraints\DateTime(),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $dateNaissance = $context->getRoot()->getData()->getDateNaissance();
                                $dateExtrait = $object;

                                if (is_a($dateNaissance, \DateTime::class) && is_a($dateExtrait, \DateTime::class)) {
                                    if ($dateExtrait->format('U') - $dateNaissance->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'extrait Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                    ->add('ecoleAnDernier', EntityType::class, [
                        'class' => EcoleProvenances::class,
                        'choice_label' => 'designation',
                        'label' => 'Ecole AN Dernier',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->orderBy('e.designation', 'ASC');
                        },
                        'placeholder' => "Sélectionnez l'école",
                        'attr' => [
                            'class' => 'select-ecole',
                        ],
                        'error_bubbling' => false,
                    ])
                    ->add('ecoleRecrutement', EntityType::class, [
                        'class' => EcoleProvenances::class,
                        'choice_label' => 'designation',

                        'label' => 'Ecole de Recrutement',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->orderBy('e.designation', 'ASC');
                        },
                        'placeholder' => "Sélectionnez l'école",
                        'attr' => [
                            'class' => 'select-ecole'
                        ],
                        'error_bubbling' => false,
                    ]);
            } else {
                $form->add('dateNaissance', DateType::class, [
                    'label' => 'Date de Naissance',
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'attr' => [
                        'min' => (new \DateTime('now -6935 days'))->format('Y-m-d'),
                        'max' => (new \DateTime('now -5840 days'))->format('Y-m-d')
                    ],
                    'auto_initialize' => false,
                ])
                    ->add('dateExtrait', DateType::class, [
                        'label' => 'Date / Extrait',
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'attr' => [
                            'min' => (new \DateTime('now -6935 days'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -1 days'))->format('Y-m-d')
                        ],
                        'auto_initialize' => false,
                        'constraints' => [
                            //new Constraints\DateTime(),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $dateNaissance = $context->getRoot()->getData()->getDateNaissance();
                                $dateExtrait = $object;

                                if (is_a($dateNaissance, \DateTime::class) && is_a($dateExtrait, \DateTime::class)) {
                                    if ($dateExtrait->format('U') - $dateNaissance->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'extrait Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                    ->add('ecoleAnDernier', EntityType::class, [
                        'class' => EcoleProvenances::class,
                        'choice_label' => 'designation',
                        'label' => 'Ecole AN Dernier',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->orderBy('e.designation', 'ASC');
                        },
                        'placeholder' => "Sélectionnez l'école",
                        'attr' => [
                            'class' => 'select-ecole',
                        ],
                        'error_bubbling' => false,
                    ])
                    ->add('ecoleRecrutement', EntityType::class, [
                        'class' => EcoleProvenances::class,
                        'choice_label' => 'designation',

                        'label' => 'Ecole de Recrutement',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->orderBy('e.designation', 'ASC');
                        },
                        'placeholder' => "Sélectionnez l'école",
                        'attr' => [
                            'class' => 'select-ecole'
                        ],
                        'error_bubbling' => false,
                    ]);
            }
        }
    }

    private function addDateRecrutementField(FormInterface $form, ?Niveaux $niveau)
    {
        if (!$niveau) {
            $form->add('dateRecrutement', DateType::class, [
                'label' => 'Date de Recrutement',
                'widget' => 'single_text',
                'auto_initialize' => false,
            ])
                ->add('dateInscription', DateType::class, [
                    'label' => "date d'Incription",
                    'widget' => 'single_text',
                    'auto_initialize' => false,
                ]);
        } else {
            $designation = $niveau->getDesignation();
            if ($designation == "Petite Section") {
                $form->add('dateRecrutement', DateType::class, [
                    'label' => 'Date de Recrutement',
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'attr' => [
                        'min' => (new \DateTime('now -365 days'))->format('Y-m-d'),
                        'max' => (new \DateTime('now -0 days'))->format('Y-m-d')
                    ],
                    'auto_initialize' => false,
                ])
                    ->add('dateInscription', DateType::class, [
                        'label' => "date d'incription",
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'attr' => [
                            'min' => (new \DateTime('now -365 days'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 days'))->format('Y-m-d')
                        ],
                        'auto_initialize' => false,
                        'constraints' => [
                            //new Constraints\DateTime(),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $recrutement = $context->getRoot()->getData()->getDateRecrutement();
                                $inscription = $object;

                                if (is_a($recrutement, \DateTime::class) && is_a($inscription, \DateTime::class)) {
                                    if ($inscription->format('U') - $recrutement->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'Inscription Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],

                    ]);
            } elseif ($designation == "Moyenne Section") {
                $form->add('dateRecrutement', DateType::class, [
                    'label' => 'Date de Recrutement',
                    'input' => 'datetime',
                    //'html5' => false,
                    'widget' => 'single_text',
                    //'data'   => new \DateTime(),
                    'attr' => [
                        'min' => (new \DateTime('now -730 days'))->format('Y-m-d'),
                        'max' => (new \DateTime('now -0 days'))->format('Y-m-d')
                    ],
                    'auto_initialize' => false,
                ])
                    ->add('dateInscription', DateType::class, [
                        'label' => "date d'incription",
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'attr' => [
                            'min' => (new \DateTime('now -730 days'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 days'))->format('Y-m-d')
                        ],
                        'auto_initialize' => false,
                        'constraints' => [
                            //new Constraints\DateTime(),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $recrutement = $context->getRoot()->getData()->getDateRecrutement();
                                $inscription = $object;

                                if (is_a($recrutement, \DateTime::class) && is_a($inscription, \DateTime::class)) {
                                    if ($inscription->format('U') - $recrutement->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'Inscription Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],

                    ]);
            } elseif ($designation == "Grande Section") {
                $form->add('dateRecrutement', DateType::class, [
                    'label' => 'Date de Recrutement',
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'attr' => [
                        'min' => (new \DateTime('now -1095 days'))->format('Y-m-d'),
                        'max' => (new \DateTime('now -0 days'))->format('Y-m-d')
                    ],
                    'auto_initialize' => false,
                ])
                    ->add('dateInscription', DateType::class, [
                        'label' => "date d'incription",
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'attr' => [
                            'min' => (new \DateTime('now -1095 days'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 days'))->format('Y-m-d')
                        ],
                        'auto_initialize' => false,
                        'constraints' => [
                            //new Constraints\DateTime(),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $recrutement = $context->getRoot()->getData()->getDateRecrutement();
                                $inscription = $object;

                                if (is_a($recrutement, \DateTime::class) && is_a($inscription, \DateTime::class)) {
                                    if ($inscription->format('U') - $recrutement->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'Inscription Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],

                    ]);
            } elseif ($designation == "1ère Année") {
                $form->add('dateRecrutement', DateType::class, [
                    'label' => 'Date de Recrutement',
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'attr' => [
                        'min' => (new \DateTime('now -1460 days'))->format('Y-m-d'),
                        'max' => (new \DateTime('now -0 days'))->format('Y-m-d')
                    ],
                    'auto_initialize' => false,
                ])
                    ->add('dateInscription', DateType::class, [
                        'label' => "date d'incription",
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'attr' => [
                            'min' => (new \DateTime('now -1460 days'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 days'))->format('Y-m-d')
                        ],
                        'auto_initialize' => false,
                        'constraints' => [
                            //new Constraints\DateTime(),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $recrutement = $context->getRoot()->getData()->getDateRecrutement();
                                $inscription = $object;

                                if (is_a($recrutement, \DateTime::class) && is_a($inscription, \DateTime::class)) {
                                    if ($inscription->format('U') - $recrutement->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'Inscription Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],

                    ]);
            } elseif ($designation == "2ème Année") {
                $form->add('dateRecrutement', DateType::class, [
                    'label' => 'Date de Recrutement',
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'attr' => [
                        'min' => (new \DateTime('now -1825 days'))->format('Y-m-d'),
                        'max' => (new \DateTime('now -365 days'))->format('Y-m-d')
                    ],
                    'auto_initialize' => false,
                ])
                    ->add('dateInscription', DateType::class, [
                        'label' => "date d'incription",
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'attr' => [
                            'min' => (new \DateTime('now -1825 days'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 days'))->format('Y-m-d')
                        ],
                        'auto_initialize' => false,
                        'constraints' => [
                            //new Constraints\DateTime(),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $recrutement = $context->getRoot()->getData()->getDateRecrutement();
                                $inscription = $object;

                                if (is_a($recrutement, \DateTime::class) && is_a($inscription, \DateTime::class)) {
                                    if ($inscription->format('U') - $recrutement->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'Inscription Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],

                    ]);
            } elseif ($designation == "3ème Année") {
                $form->add('dateRecrutement', DateType::class, [
                    'label' => 'Date de Recrutement',
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'attr' => [
                        'min' => (new \DateTime('now -2190 days'))->format('Y-m-d'),
                        'max' => (new \DateTime('now -730 days'))->format('Y-m-d')
                    ],
                    'auto_initialize' => false,
                ])
                    ->add('dateInscription', DateType::class, [
                        'label' => "date d'incription",
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'attr' => [
                            'min' => (new \DateTime('now -2190 days'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 days'))->format('Y-m-d')
                        ],
                        'auto_initialize' => false,
                        'constraints' => [
                            //new Constraints\DateTime(),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $recrutement = $context->getRoot()->getData()->getDateRecrutement();
                                $inscription = $object;

                                if (is_a($recrutement, \DateTime::class) && is_a($inscription, \DateTime::class)) {
                                    if ($inscription->format('U') - $recrutement->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'Inscription Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],

                    ]);
            } elseif ($designation == "4ème Année") {
                $form->add('dateRecrutement', DateType::class, [
                    'label' => 'Date de Recrutement',
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'attr' => [
                        'min' => (new \DateTime('now -2555 days'))->format('Y-m-d'),
                        'max' => (new \DateTime('now -1095 days'))->format('Y-m-d')
                    ],
                    'auto_initialize' => false,
                ])
                    ->add('dateInscription', DateType::class, [
                        'label' => "date d'incription",
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'attr' => [
                            'min' => (new \DateTime('now -2555 days'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 days'))->format('Y-m-d')
                        ],
                        'auto_initialize' => false,
                        'constraints' => [
                            //new Constraints\DateTime(),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $recrutement = $context->getRoot()->getData()->getDateRecrutement();
                                $inscription = $object;

                                if (is_a($recrutement, \DateTime::class) && is_a($inscription, \DateTime::class)) {
                                    if ($inscription->format('U') - $recrutement->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'Inscription Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],

                    ]);
            } elseif ($designation == "5ème Année") {
                $form->add('dateRecrutement', DateType::class, [
                    'label' => 'Date de Recrutement',
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'attr' => [
                        'min' => (new \DateTime('now -2920 days'))->format('Y-m-d'),
                        'max' => (new \DateTime('now -1460 days'))->format('Y-m-d')
                    ],
                    'auto_initialize' => false,
                ])
                    ->add('dateInscription', DateType::class, [
                        'label' => "date d'incription",
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'attr' => [
                            'min' => (new \DateTime('now -2920 days'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 days'))->format('Y-m-d')
                        ],
                        'auto_initialize' => false,
                        'constraints' => [
                            //new Constraints\DateTime(),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $recrutement = $context->getRoot()->getData()->getDateRecrutement();
                                $inscription = $object;

                                if (is_a($recrutement, \DateTime::class) && is_a($inscription, \DateTime::class)) {
                                    if ($inscription->format('U') - $recrutement->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'Inscription Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],

                    ]);
            } elseif ($designation == "6ème Année") {
                $form->add('dateRecrutement', DateType::class, [
                    'label' => 'Date de Recrutement',
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'attr' => [
                        'min' => (new \DateTime('now -3285 days'))->format('Y-m-d'),
                        'max' => (new \DateTime('now -1825 days'))->format('Y-m-d')
                    ],
                    'auto_initialize' => false,
                ])
                    ->add('dateInscription', DateType::class, [
                        'label' => "date d'incription",
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'attr' => [
                            'min' => (new \DateTime('now -3285 days'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 days'))->format('Y-m-d')
                        ],
                        'auto_initialize' => false,
                        'constraints' => [
                            //new Constraints\DateTime(),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $recrutement = $context->getRoot()->getData()->getDateRecrutement();
                                $inscription = $object;

                                if (is_a($recrutement, \DateTime::class) && is_a($inscription, \DateTime::class)) {
                                    if ($inscription->format('U') - $recrutement->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'Inscription Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],

                    ]);
            } elseif ($designation == "7ème Année") {
                $form->add('dateRecrutement', DateType::class, [
                    'label' => 'Date de Recrutement',
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'attr' => [
                        'min' => (new \DateTime('now -3650 days'))->format('Y-m-d'),
                        'max' => (new \DateTime('now -2190 days'))->format('Y-m-d')
                    ],
                    'auto_initialize' => false,
                ])
                    ->add('dateInscription', DateType::class, [
                        'label' => "date d'incription",
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'attr' => [
                            'min' => (new \DateTime('now -3650 days'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 days'))->format('Y-m-d')
                        ],
                        'auto_initialize' => false,
                        'constraints' => [
                            //new Constraints\DateTime(),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $recrutement = $context->getRoot()->getData()->getDateRecrutement();
                                $inscription = $object;

                                if (is_a($recrutement, \DateTime::class) && is_a($inscription, \DateTime::class)) {
                                    if ($inscription->format('U') - $recrutement->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'Inscription Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ]);
            } elseif ($designation == "8ème Année") {
                $form->add('dateRecrutement', DateType::class, [
                    'label' => 'Date de Recrutement',
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'attr' => [
                        'min' => (new \DateTime('now -4015 days'))->format('Y-m-d'),
                        'max' => (new \DateTime('now -2555 days'))->format('Y-m-d')
                    ],
                    'auto_initialize' => false,
                ])
                    ->add('dateInscription', DateType::class, [
                        'label' => "date d'incription",
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'attr' => [
                            'min' => (new \DateTime('now -4015 days'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 days'))->format('Y-m-d')
                        ],
                        'auto_initialize' => false,
                        'constraints' => [
                            //new Constraints\DateTime(),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $recrutement = $context->getRoot()->getData()->getDateRecrutement();
                                $inscription = $object;

                                if (is_a($recrutement, \DateTime::class) && is_a($inscription, \DateTime::class)) {
                                    if ($inscription->format('U') - $recrutement->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'Inscription Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],

                    ]);
            } elseif ($designation == "9ème Année") {
                $form->add('dateRecrutement', DateType::class, [
                    'label' => 'Date de Recrutement',
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'attr' => [
                        'min' => (new \DateTime('now -4380 days'))->format('Y-m-d'),
                        'max' => (new \DateTime('now -2920 days'))->format('Y-m-d')
                    ],
                    'auto_initialize' => false,
                ])
                    ->add('dateInscription', DateType::class, [
                        'label' => "date d'incription",
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'attr' => [
                            'min' => (new \DateTime('now -4380 days'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 days'))->format('Y-m-d')
                        ],
                        'auto_initialize' => false,
                        'constraints' => [
                            //new Constraints\DateTime(),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $recrutement = $context->getRoot()->getData()->getDateRecrutement();
                                $inscription = $object;

                                if (is_a($recrutement, \DateTime::class) && is_a($inscription, \DateTime::class)) {
                                    if ($inscription->format('U') - $recrutement->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'Inscription Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],

                    ]);
            } elseif ($designation == "10ème Année") {
                $form->add('dateRecrutement', DateType::class, [
                    'label' => 'Date de Recrutement',
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'attr' => [
                        'min' => (new \DateTime('now -4745 days'))->format('Y-m-d'),
                        'max' => (new \DateTime('now -3285 days'))->format('Y-m-d')
                    ],
                    'auto_initialize' => false,
                ])
                    ->add('dateInscription', DateType::class, [
                        'label' => "date d'incription",
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'attr' => [
                            'min' => (new \DateTime('now -4745 days'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 days'))->format('Y-m-d')
                        ],
                        'auto_initialize' => false,
                        'constraints' => [
                            //new Constraints\DateTime(),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $recrutement = $context->getRoot()->getData()->getDateRecrutement();
                                $inscription = $object;

                                if (is_a($recrutement, \DateTime::class) && is_a($inscription, \DateTime::class)) {
                                    if ($inscription->format('U') - $recrutement->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'Inscription Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],

                    ]);
            } elseif ($designation == "11ème Année") {
                $form->add('dateRecrutement', DateType::class, [
                    'label' => 'Date de Recrutement',
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'attr' => [
                        'min' => (new \DateTime('now -5110 days'))->format('Y-m-d'),
                        'max' => (new \DateTime('now -3650 days'))->format('Y-m-d')
                    ],
                    'auto_initialize' => false,
                ])
                    ->add('dateInscription', DateType::class, [
                        'label' => "date d'incription",
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'attr' => [
                            'min' => (new \DateTime('now -5110 days'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 days'))->format('Y-m-d')
                        ],
                        'auto_initialize' => false,
                        'constraints' => [
                            //new Constraints\DateTime(),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $recrutement = $context->getRoot()->getData()->getDateRecrutement();
                                $inscription = $object;

                                if (is_a($recrutement, \DateTime::class) && is_a($inscription, \DateTime::class)) {
                                    if ($inscription->format('U') - $recrutement->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'Inscription Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],

                    ]);
            } else {
                $form->add('dateRecrutement', DateType::class, [
                    'label' => 'Date de Recrutement',
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'attr' => [
                        'min' => (new \DateTime('now -5475 days'))->format('Y-m-d'),
                        'max' => (new \DateTime('now -4015 days'))->format('Y-m-d')
                    ],
                    'auto_initialize' => false,
                ])
                    ->add('dateInscription', DateType::class, [
                        'label' => "date d'incription",
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'attr' => [
                            'min' => (new \DateTime('now -5475 days'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 days'))->format('Y-m-d')
                        ],
                        'auto_initialize' => false,
                        'constraints' => [
                            //new Constraints\DateTime(),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $recrutement = $context->getRoot()->getData()->getDateRecrutement();
                                $inscription = $object;

                                if (is_a($recrutement, \DateTime::class) && is_a($inscription, \DateTime::class)) {
                                    if ($inscription->format('U') - $recrutement->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'Inscription Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],

                    ]);
            }
        }
    }

    private function addScolarites1Field(FormInterface $form, ?Niveaux $niveaux)
    {
        $designation = $niveaux ? $niveaux->getDesignation() : [];
        $scolarite1 = $niveaux ? $niveaux->getScolarites1s() : [];
        if (
            $designation == '1ère Année' || $designation == '2ème Année'
            || $designation == '3ème Année' || $designation == '4ème Année'
            || $designation == '5ème Année' || $designation == '6ème Année'
            || $designation == '7ème Année' || $designation == '8ème Année'
            || $designation == '9ème Année'
        ) {
            $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
                'scolarite1',
                EntityType::class,
                null,
                [
                    'class' => Scolarites1::class,
                    'choice_label' => 'scolarite',
                    'label' => '1er Cycle',
                    'choices' => $niveaux?->getScolarites1s(),
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('s1')
                            ->orderBy('s1.scolarite', 'ASC');
                    },
                    'auto_initialize' => false,
                    'placeholder' => '###',
                    'error_bubbling' => false,
                    'attr' => [
                        'class' => 'select-scolarite'
                    ],
                    'constraints' => [
                        new Assert\NotBlank(),
                    ],
                ]
            );
            $builder->addEventListener(
                FormEvents::POST_SUBMIT,
                function (FormEvent $event) {
                    $form = $event->getForm();
                    $data = $form->getData();
                    $this->addScolarites2Field($form->getParent(), $form->getData());
                }
            );

            $form->add($builder->getForm());
        } else {
            $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
                'scolarite1',
                EntityType::class,
                null,
                [
                    'class' => Scolarites1::class,
                    'choice_label' => 'scolarite',
                    'label' => '1er Cycle',
                    'choices' => $niveaux?->getScolarites1s(),
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('s1')
                            ->orderBy('s1.scolarite', 'ASC');
                    },
                    'auto_initialize' => false,
                    'placeholder' => '###',
                    'error_bubbling' => false,
                    'attr' => [
                        'class' => 'select-scolarite',
                        'disabled' => 'disabled',
                    ],

                ]
            );
            $builder->addEventListener(
                FormEvents::POST_SUBMIT,
                function (FormEvent $event) {
                    $form = $event->getForm();
                    $data = $form->getData();
                    $this->addScolarites2Field($form->getParent(), $form->getData());
                }
            );

            $form->add($builder->getForm());
        }
    }

    private function addScolarites2Field(FormInterface $form, ?Scolarites1 $scolarites1)
    {
        $designation = $scolarites1 ? $scolarites1->getNiveau()->getDesignation() : [];

        if (
            $scolarites1 !== null &&
            ($designation == '1ère Année' || $designation == '2ème Année'
                || $designation == '3ème Année' || $designation == '4ème Année'
                || $designation == '5ème Année' || $designation == '6ème Année'
                || $designation == '7ème Année' || $designation == '8ème Année'
                || $designation == '9ème Année')
        ) {
            $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
                'scolarite2',
                EntityType::class,
                null,
                [
                    'class' => Scolarites2::class,
                    'choice_label' => 'scolarite',
                    'label' => '2nd Cycle',
                    'choices' => $scolarites1 ? $scolarites1->getScolarites2s() : [],
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('s1')
                            ->orderBy('s1.scolarite', 'ASC');
                    },
                    'required' => true,
                    'auto_initialize' => false,
                    'placeholder' => '###',
                    'error_bubbling' => false,
                    'attr' => [
                        'class' => 'select-scolarite'
                    ],
                    'constraints' => [
                        new Assert\NotBlank(),
                    ],

                ]
            );
            $builder->addEventListener(
                FormEvents::POST_SUBMIT,
                function (FormEvent $event) {
                    $form = $event->getForm();
                    $data = $form->getData();
                    $this->addRedoublement1Field($form->getParent(), $form->getData());
                }
            );

            $form->add($builder->getForm());
        } else {
            $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
                'scolarite2',
                EntityType::class,
                null,
                [
                    'class' => Scolarites2::class,
                    'choice_label' => 'scolarite',
                    'label' => '2nd Cycle',
                    'choices' => $scolarites1 ? $scolarites1->getScolarites2s() : [],
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('s1')
                            ->orderBy('s1.scolarite', 'ASC');
                    },
                    'auto_initialize' => false,
                    'placeholder' => '###',
                    'required' => false,
                    'error_bubbling' => false,
                    'attr' => [
                        'class' => 'select-scolarite',
                        'disabled' => 'disabled',
                    ]
                ]
            );
            $builder->addEventListener(
                FormEvents::POST_SUBMIT,
                function (FormEvent $event) {
                    $form = $event->getForm();
                    $data = $form->getData();
                    $this->addRedoublement1Field($form->getParent(), $form->getData());
                }
            );

            $form->add($builder->getForm());
        }
    }

    public function addRedoublement1Field(FormInterface $form, ?Scolarites2 $scolarites2)
    {
        $scolarites1 = $scolarites2 ? $scolarites2->getScolarite1() : [];
        $designation = $scolarites2 ? $scolarites2->getNiveau()->getDesignation() : [];
        $scolarite1 = $scolarites1 ? $scolarites1->getScolarite() : [];
        $scolarite2 = $scolarites2 ? $scolarites2->getScolarite() : [];

        if (($designation == "1ère Année" && $scolarite1 >= 2 && $scolarite2 == 0)
            || ($designation == "2ème Année" && $scolarite1 >= 3 && $scolarite2 == 0)
            || ($designation == "3ème Année" && $scolarite1 >= 4 && $scolarite2 == 0)
            || ($designation == "4ème Année" && $scolarite1 >= 5 && $scolarite2 == 0)
            || ($designation == "5ème Année" && $scolarite1 >= 6 && $scolarite2 == 0)
            || ($designation == "6ème Année" && $scolarite1 >= 7 && $scolarite2 == 0)
            || ($designation == "7ème Année" && $scolarite1 >= 7 && $scolarite2 == 1)
            || ($designation == "7ème Année" && $scolarite1 >= 6 && $scolarite2 >= 2)
            || ($designation == "8ème Année" && $scolarite1 >= 7 && $scolarite2 == 2)
            || ($designation == "8ème Année" && $scolarite1 >= 6 && $scolarite2 >= 3)
            || ($designation == "9ème Année" && $scolarite1 >= 7 && $scolarite2 == 3)
            || ($designation == "8ème Année" && $scolarite1 >= 6 && $scolarite2 >= 4)
        ) {
            $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
                'redoublement1',
                EntityType::class,
                null,
                [
                    'class' => Redoublements1::class,
                    'label' => '1er Redoub',
                    'choices' => $scolarites2 ? $this->redoublements1Repository->findByScolarites1AndScolarites2($scolarites1, $scolarites2) : [],
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('r1')
                            ->orderBy('r1.niveau', 'ASC');
                    },
                    'auto_initialize' => false,
                    'placeholder' => '###',
                    'error_bubbling' => false,
                    'constraints' => [
                        new NotBlank([
                            'message' => '1er Redoublement obligatoire',
                        ]),
                    ],
                ]
            );
            $builder->addEventListener(
                FormEvents::POST_SUBMIT,
                function (FormEvent $event) {
                    $form = $event->getForm();
                    $data = $event->getData();
                    $this->addRedoublement2Field($form->getParent(), $form->getData());
                }
            );
            $form->add($builder->getForm());
        } else {
            $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
                'redoublement1',
                EntityType::class,
                null,
                [
                    'class' => Redoublements1::class,
                    'label' => '1er Redoub',
                    'choices' => $scolarites2 ? $this->redoublements1Repository->findByScolarites1ANDScolarites2($scolarites1, $scolarites2) : [],
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('r1')
                            ->orderBy('r1.niveau', 'ASC');
                    },
                    'auto_initialize' => false,
                    'required' => false,
                    'placeholder' => '###',
                    'error_bubbling' => false,
                ]
            );
            $builder->addEventListener(
                FormEvents::POST_SUBMIT,
                function (FormEvent $event) {
                    $form = $event->getForm();
                    $data = $event->getData();
                    $this->addRedoublement2Field($form->getParent(), $form->getData());
                }
            );
            $form->add($builder->getForm());
        }
    }
    public function addRedoublement2Field(FormInterface $form, ?Redoublements1 $redoublements1)
    {
        $scolarites2 = $redoublements1 ? $redoublements1->getScolarite2() : [];
        $scolarites1 = $scolarites2 ? $scolarites2->getScolarite1() : [];
        $designation = $scolarites2 ? $scolarites2->getNiveau()->getDesignation() : [];
        $scolarite1 = $scolarites1 ? $scolarites1->getScolarite() : [];
        $scolarite2 = $scolarites2 ? $scolarites2->getScolarite() : [];

        if (($designation == "1ère Année" && $scolarite1 >= 3 && $scolarite2 == 0)
            || ($designation == "2ème Année" && $scolarite1 >= 4 && $scolarite2 == 0)
            || ($designation == "3ème Année" && $scolarite1 >= 5 && $scolarite2 == 0)
            || ($designation == "4ème Année" && $scolarite1 >= 6 && $scolarite2 == 0)
            || ($designation == "5ème Année" && $scolarite1 >= 7 && $scolarite2 == 0)
            || ($designation == "6ème Année" && $scolarite1 >= 8 && $scolarite2 == 0)
            //2 redoublement au 1er Cycle
            || ($designation == "7ème Année" && $scolarite1 >= 8 && $scolarite2 == 1)
            || ($designation == "8ème Année" && $scolarite1 >= 8 && $scolarite2 == 2)
            || ($designation == "9ème Année" && $scolarite1 >= 8 && $scolarite2 == 3)
            //1 redoublement au 1er cycle -- 1 redoublement au 2nd cycle
            || ($designation == "7ème Année" && $scolarite1 >= 7 && $scolarite2 >= 2)
            || ($designation == "8ème Année" && $scolarite1 >= 7 && $scolarite2 >= 3)
            || ($designation == "9ème Année" && $scolarite1 >= 7 && $scolarite2 >= 4)
            //2 redoublements au 2nd cycle
            || ($designation == "7ème Année" && $scolarite1 == 6 && $scolarite2 >= 3)
            || ($designation == "8ème Année" && $scolarite1 == 6 && $scolarite2 >= 4)
            || ($designation == "9ème Année" && $scolarite1 == 6 && $scolarite2 >= 5)
        ) {
            $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
                'redoublement2',
                EntityType::class,
                null,
                [
                    'class' => Redoublements2::class,
                    //'choice_label' => 'niveau',
                    'label' => '2ème Redoub',
                    'choices' => $redoublements1 ? $redoublements1->getRedoublements2s() : [],
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('r1')
                            ->orderBy('r1.niveau', 'ASC');
                    },
                    'auto_initialize' => false,
                    'placeholder' => '###',
                    'error_bubbling' => false,
                    'constraints' => [
                        new NotBlank([
                            'message' => '2ème Redoublement obligatoire',
                        ]),
                    ],
                ]
            );
            $builder->addEventListener(
                FormEvents::POST_SUBMIT,
                function (FormEvent $event) {
                    $form = $event->getForm();
                    $data = $event->getData();
                    $this->addRedoublement3Field($form->getParent(), $form->getData());
                }
            );
            $form->add($builder->getForm());
        } else {
            $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
                'redoublement2',
                EntityType::class,
                null,
                [
                    'class' => Redoublements2::class,
                    //'choice_label' => 'niveau',
                    'label' => '2ème Redoub',
                    'choices' => $redoublements1 ? $redoublements1->getRedoublements2s() : [],
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('r1')
                            ->orderBy('r1.niveau', 'ASC');
                    },
                    'auto_initialize' => false,
                    'placeholder' => '###',
                    'error_bubbling' => false,
                    'required' => false,
                ]
            );
            $builder->addEventListener(
                FormEvents::POST_SUBMIT,
                function (FormEvent $event) {
                    $form = $event->getForm();
                    $data = $event->getData();
                    $this->addRedoublement3Field($form->getParent(), $form->getData());
                }
            );
            $form->add($builder->getForm());
        }
    }

    public function addRedoublement3Field(FormInterface $form, ?Redoublements2 $redoublements2)
    {
        $scolarites2 = $redoublements2 ? $redoublements2->getScolarite2() : [];
        $scolarites1 = $scolarites2 ? $scolarites2->getScolarite1() : [];
        $designation = $scolarites2 ? $scolarites2->getNiveau()->getDesignation() : [];
        $scolarite1 = $scolarites1 ? $scolarites1->getScolarite() : [];
        $scolarite2 = $scolarites2 ? $scolarites2->getScolarite() : [];

        if (($designation == "1ère Année" && $scolarite1 >= 4 && $scolarite2 == 0)
            || ($designation == "2ème Année" && $scolarite1 >= 5 && $scolarite2 == 0)
            || ($designation == "3ème Année" && $scolarite1 >= 6 && $scolarite2 == 0)
            || ($designation == "4ème Année" && $scolarite1 >= 7 && $scolarite2 == 0)
            || ($designation == "5ème Année" && $scolarite1 >= 8 && $scolarite2 == 0)
            || ($designation == "6ème Année" && $scolarite1 >= 9 && $scolarite2 == 0)
            //2 redoublement au 1er Cycle 1 redoublement au 2nd cycle
            || ($designation == "7ème Année" && $scolarite1 >= 8 && $scolarite2 >= 2)
            || ($designation == "8ème Année" && $scolarite1 >= 8 && $scolarite2 >= 3)
            || ($designation == "9ème Année" && $scolarite1 >= 8 && $scolarite2 >= 4)
            //1 redoublement au 1er cycle -- 2 redoublement au 2nd cycle
            || ($designation == "7ème Année" && $scolarite1 >= 7 && $scolarite2 >= 3)
            || ($designation == "8ème Année" && $scolarite1 >= 7 && $scolarite2 >= 4)
            || ($designation == "9ème Année" && $scolarite1 >= 7 && $scolarite2 >= 5)
            //3 redoublements au 2nd cycle
            || ($designation == "7ème Année" && $scolarite1 == 6 && $scolarite2 >= 4)
            || ($designation == "8ème Année" && $scolarite1 == 6 && $scolarite2 >= 5)
            || ($designation == "9ème Année" && $scolarite1 == 6 && $scolarite2 >= 6)
        ) {
            $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
                'redoublement3',
                EntityType::class,
                null,
                [
                    'class' => Redoublements3::class,
                    //'choice_label' => 'niveau',
                    'label' => '3ème Redoub',
                    'choices' =>  $redoublements2 ? $redoublements2->getRedoublements3s() : [],
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('r1')
                            ->orderBy('r1.niveau', 'ASC');
                    },
                    'auto_initialize' => false,
                    'placeholder' => '###',
                    'error_bubbling' => false,
                    'constraints' => [
                        new NotBlank([
                            'message' => '3ème Redoublement obligatoire',
                        ]),
                    ],

                ]
            );
            $form->add($builder->getForm());
        } else {
            $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
                'redoublement3',
                EntityType::class,
                null,
                [
                    'class' => Redoublements3::class,
                    //'choice_label' => 'niveau',
                    'label' => '3ème Redoub',
                    'choices' =>  $redoublements2 ? $redoublements2->getRedoublements3s() : [],
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('r1')
                            ->orderBy('r1.niveau', 'ASC');
                    },
                    'auto_initialize' => false,
                    'placeholder' => '###',
                    'required' => false,
                    'error_bubbling' => false,
                ]
            );
            $form->add($builder->getForm());
        }
    }

    public function addCerclesField(FormInterface $form, ?Regions $regions)
    {
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'cercle',
            EntityType::class,
            null,
            [
                'class' => Cercles::class,
                'choice_label' => 'designation',
                'auto_initialize' => false,
                'label' => 'Cercle de :',
                'choices' => $regions ? $regions->getCercles() : [],
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.designation', 'ASC');
                },
                'placeholder' => $regions ? 'Entrer ou Choisir un Cercle' : 'Entrer ou Choisir une Région',
                'attr' => [
                    'class' => 'select-cercle'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                ],
                'required' => false,
                'mapped' => false,
                'error_bubbling' => false,
            ]
        );

        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $data = $form->getData();
                $this->addCommunesField($form->getParent(), $form->getData());
            }
        );

        $form->add($builder->getForm());
    }

    public function addCommunesField(FormInterface $form, ?Cercles $cercles)
    {
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'commune',
            EntityType::class,
            null,
            [
                'class' => Communes::class,
                'choice_label' => 'designation',
                'label' => 'Commune de :',
                'auto_initialize' => false,
                'choices' => $cercles ? $cercles->getCommunes() : [],
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.designation', 'ASC');
                },
                'placeholder' => $cercles ? 'Entrer ou Choisir une Commune' : 'Entrer ou Choisir un Cercle',
                'attr' => [
                    'class' => 'select-commune'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                ],
                'required' => false,
                'mapped' => false,
                'error_bubbling' => false,
            ]
        );

        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $data = $form->getData();
                $this->addLieuNaissanceField($form->getParent(), $form->getData());
            }
        );

        $form->add($builder->getForm());
    }

    public function addLieuNaissanceField(FormInterface $form, ?Communes $communes)
    {
        $form->add('lieuNaissance', EntityType::class, [
            'class' => LieuNaissances::class,
            'choice_label' => 'designation',
            'choices' => $communes ? $communes->getLieuNaissances() : [],
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('l')
                    ->orderBy('l.designation', 'ASC');
            },
            'placeholder' => $communes ? 'Entrer ou Choisir le lieu de Naissance' : 'Entrer ou Choisir la Commune',
            'attr' => [
                'class' => 'select-lieu'
            ],
            'required' => false,
            'error_bubbling' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Eleves::class,
        ]);
    }
}