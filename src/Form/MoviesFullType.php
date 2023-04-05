<?php

namespace App\Form;

use App\Entity\MoviesFull;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MoviesFullType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('year')
            ->add('genres')
            ->add('plot')
            ->add('directors')
            ->add('cast')
            ->add('writers')
            ->add('runtime')
            ->add('modified')
            ->add('created')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MoviesFull::class,
        ]);
    }
}
