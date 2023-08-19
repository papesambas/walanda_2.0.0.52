<?php

namespace App\Form;

use App\Entity\FraisScolarites;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FraisScolaritesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('inscription')
            ->add('carnet')
            ->add('transfert')
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
            ->add('autre')
            ->add('eleve')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FraisScolarites::class,
        ]);
    }
}
