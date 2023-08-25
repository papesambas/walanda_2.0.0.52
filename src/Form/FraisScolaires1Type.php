<?php

namespace App\Form;

use App\Entity\FraisScolaires;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FraisScolaires1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('designation')
            ->add('montant')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('statut')
            ->add('niveau')
            ->add('echeance')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FraisScolaires::class,
        ]);
    }
}
