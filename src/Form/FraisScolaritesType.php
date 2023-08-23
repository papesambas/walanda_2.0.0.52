<?php

namespace App\Form;

use App\Entity\FraisScolarites;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GroupSequence;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\PositiveOrZero;

class FraisScolaritesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('inscription', IntegerType::class, [
                'label' => 'Inscription',
                'grouping' => true, // Active le formatage des milliers
                'constraints' => [
                    new GroupSequence([
                        new PositiveOrZero([
                            'message' => 'Le montant de l\'inscription doit être positif ou nul.',
                        ]),
                    ]),
                ],
            ])
            ->add('carnet', IntegerType::class, [
                'label' => 'Carnet',
                'grouping' => true, // Active le formatage des milliers
                'constraints' => [
                    new GroupSequence([
                        new PositiveOrZero([
                            'message' => 'Le montant des frais de carnet doit être positif ou nul.',
                        ]),
                    ]),
                ],
            ])
            ->add('transfert', IntegerType::class, [
                'label' => 'transfert',
                'grouping' => true, // Active le formatage des milliers
                'constraints' => [
                    new GroupSequence([
                        new PositiveOrZero([
                            'message' => 'Le montant des frais de transfert doit être positif ou nul.',
                        ]),
                    ]),
                ],
            ])
            ->add('septembre', IntegerType::class, [
                'label' => 'Sept',
                'grouping' => true, // Active le formatage des milliers
                'constraints' => [
                    new GroupSequence([
                        new PositiveOrZero([
                            'message' => 'Le montant des frais scolaires doit être positif ou nul.',
                        ]),
                    ]),
                ],
            ])
            ->add('octobre', IntegerType::class, [
                'label' => 'Oct',
                'grouping' => true, // Active le formatage des milliers
                'constraints' => [
                    new GroupSequence([
                        new PositiveOrZero([
                            'message' => 'Le montant des frais scolaires doit être positif ou nul.',
                        ]),
                    ]),
                ],
            ])
            ->add('novembre', IntegerType::class, [
                'label' => 'Nov',
                'grouping' => true, // Active le formatage des milliers
                'constraints' => [
                    new GroupSequence([
                        new PositiveOrZero([
                            'message' => 'Le montant des frais scolaires doit être positif ou nul.',
                        ]),
                    ]),
                ],
            ])
            ->add('decembre', IntegerType::class, [
                'label' => 'Déc',
                'grouping' => true, // Active le formatage des milliers
                'constraints' => [
                    new GroupSequence([
                        new PositiveOrZero([
                            'message' => 'Le montant des frais scolaires doit être positif ou nul.',
                        ]),
                    ]),
                ],
            ])
            ->add('janvier', IntegerType::class, [
                'label' => 'Janv',
                'grouping' => true, // Active le formatage des milliers
                'constraints' => [
                    new GroupSequence([
                        new PositiveOrZero([
                            'message' => 'Le montant des frais scolaires doit être positif ou nul.',
                        ]),
                    ]),
                ],
            ])
            ->add('fevrier', IntegerType::class, [
                'label' => 'Fév',
                'grouping' => true, // Active le formatage des milliers
                'constraints' => [
                    new GroupSequence([
                        new PositiveOrZero([
                            'message' => 'Le montant des frais scolaires doit être positif ou nul.',
                        ]),
                    ]),
                ],
            ])
            ->add('mars', IntegerType::class, [
                'label' => 'Mars',
                'grouping' => true, // Active le formatage des milliers
                'constraints' => [
                    new GroupSequence([
                        new PositiveOrZero([
                            'message' => 'Le montant des frais scolaires doit être positif ou nul.',
                        ]),
                    ]),
                ],
            ])
            ->add('avril', IntegerType::class, [
                'label' => 'Avr',
                'grouping' => true, // Active le formatage des milliers
                'constraints' => [
                    new GroupSequence([
                        new PositiveOrZero([
                            'message' => 'Le montant des frais scolaires doit être positif ou nul.',
                        ]),
                    ]),
                ],
            ])
            ->add('mai', IntegerType::class, [
                'label' => 'Mai',
                'grouping' => true, // Active le formatage des milliers
                'constraints' => [
                    new GroupSequence([
                        new PositiveOrZero([
                            'message' => 'Le montant des frais scolaires doit être positif ou nul.',
                        ]),
                    ]),
                ],
            ])
            ->add('juin', IntegerType::class, [
                'label' => 'Juin',
                'grouping' => true, // Active le formatage des milliers
                'constraints' => [
                    new GroupSequence([
                        new PositiveOrZero([
                            'message' => 'Le montant des frais scolaires doit être positif ou nul.',
                        ]),
                    ]),
                ],
            ])
            ->add('autre', IntegerType::class, [
                'label' => 'Autres',
                'grouping' => true, // Active le formatage des milliers
                'constraints' => [
                    new GroupSequence([
                        new PositiveOrZero([
                            'message' => 'Le montant des frais scolaires doit être positif ou nul.',
                        ]),
                    ]),
                ],
            ])
            ->add('eleve');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FraisScolarites::class,
        ]);
    }
}
