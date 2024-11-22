<?php

namespace App\Form;

use App\Entity\SuperHero;
use App\Entity\Power;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SuperHeroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('alterEgo')
            ->add('energyLevel')
            ->add('isAvailable')
            ->add('biography', TextareaType::class, [
                'label' => 'Biographie',
                'required' => true,
            ])
            ->add('disability', TextareaType::class, [
                'label' => 'Handicap',
                'required' => true,
            ])
            ->add('image', FileType::class, [
                'label' => 'Image du héros',
                'mapped' => false,
                'required' => false
            ])
            ->add('powers', EntityType::class, [
                'class' => Power::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('newPower', PowerType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Ajouter un nouveau pouvoir',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SuperHero::class,
        ]);
    }
}
