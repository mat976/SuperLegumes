<?php

namespace App\Form;

use App\Entity\Mission;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description'
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'En attente' => 'En attente',
                    'En cours' => 'En cours',
                    'Terminée' => 'Terminée',
                    'Annulée' => 'Annulée'
                ]
            ])
            ->add('startAt', DateTimeType::class, [
                'label' => 'Date de début',
                'widget' => 'single_text'
            ])
            ->add('endAt', DateTimeType::class, [
                'label' => 'Date de fin',
                'widget' => 'single_text'
            ])
            ->add('location', TextType::class, [
                'label' => 'Lieu'
            ])
            ->add('dangerLevel', IntegerType::class, [
                'label' => 'Niveau de danger',
                'attr' => [
                    'min' => 1,
                    'max' => 10
                ]
            ])
            ->add('assignedTeam', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name',
                'label' => 'Équipe assignée',
                'required' => false,
                'placeholder' => 'Sélectionner une équipe',
            ])
            ->add('assign', SubmitType::class, [
                'label' => 'Assigner à une équipe',
                'attr' => ['class' => 'btn btn-primary'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mission::class,
        ]);
    }
}
