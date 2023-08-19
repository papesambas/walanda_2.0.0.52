<?php

namespace App\Form;

use App\Entity\FraisScolaires;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FraisScolairesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fraisInscription')
            ->add('fraisCarnet')
            ->add('fraisTransfert')
            ->add('septembre')
            ->add('octobre')
            ->add('novembre')
            ->add('decembre')
            ->add('janvier')
            ->add('fevrier')
            ->add('mars')
            ->add('avril')
            ->add('mai')
            ->add('juin')
            ->add('autres')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('niveau')
            ->add('statut')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FraisScolaires::class,
        ]);
    }
}
