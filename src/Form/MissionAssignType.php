<?php

namespace App\Form;

use App\Entity\Mission;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionAssignType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('assignedTeam', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name',
                'label' => 'Équipe à assigner',
                'required' => true,
                'placeholder' => 'Sélectionner une équipe',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Mission::class,
        ]);
    }
}
