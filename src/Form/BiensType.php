<?php

namespace App\Form;

use App\Entity\Biens;
use App\Entity\Templates;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BiensType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('template', EntityType::class, [
                'class' => Templates::class,
                'expanded' => false,
                'required' => true,
                'choice_label' => 'title',
                'multiple' => false
            ])
            ->add('user', EntityType::class, [
                'class' => Users::class,
                'expanded' => false,
                'required' => true,
                'choice_label' => 'email',
                'multiple' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Biens::class,
        ]);
    }
}
