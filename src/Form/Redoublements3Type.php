<?php

namespace App\Form;

use App\Entity\Redoublements3;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Redoublements3Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('niveau')
            ->add('redoublement2')
            ->add('scolarite1')
            ->add('scolarite2')
            ->add('scolarite3')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Redoublements3::class,
        ]);
    }
}
