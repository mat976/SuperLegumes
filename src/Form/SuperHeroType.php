<?php

namespace App\Form;

use App\Entity\SuperHero;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SuperHeroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('alterEgo', TextType::class, [
                'label' => 'Alter Ego',
                'required' => false
            ])
            ->add('energyLevel', IntegerType::class, [
                'label' => 'Niveau d\'énergie'
            ])
            ->add('isAvailable', CheckboxType::class, [
                'label' => 'Disponible',
                'required' => false
            ])
            ->add('biography', TextareaType::class, [
                'label' => 'Biographie'
            ])
            ->add('disability', TextareaType::class, [
                'label' => 'Handicap'
            ])
            ->add('image', FileType::class, [
                'label' => 'Image (JPG, PNG file)',
                'mapped' => false,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SuperHero::class,
        ]);
    }
}
