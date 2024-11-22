<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\SuperHero;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class TeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'équipe'
            ])
            ->add('leader', EntityType::class, [
                'class' => SuperHero::class,
                'choice_label' => 'name',
                'label' => 'Leader de l\'équipe'
            ])
            ->add('members', EntityType::class, [
                'class' => SuperHero::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Membres de l\'équipe'
            ])
            ->add('isActive', CheckboxType::class, [
                'label' => 'Équipe active',
                'required' => false
            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}
