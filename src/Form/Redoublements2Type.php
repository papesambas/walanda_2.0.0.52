<?php

namespace App\Form;

use App\Entity\Redoublements2;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Redoublements2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('niveau')
            ->add('redoublement1')
            ->add('scolarite1')
            ->add('scolarite2')
            ->add('scolarite3')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Redoublements2::class,
        ]);
    }
}
