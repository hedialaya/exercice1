<?php

namespace App\Form;


use App\Entity\Contrat;
use App\Entity\Job;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class OffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('label' => 'titre :'))
            ->add('description', TextType::class, array('label' => 'description :'))
            ->add('contrat', EntityType::class, ['class' => Contrat::class, 'choice_label' => 'name'])
            ->add('job', EntityType::class, ['class' => Job::class, 'choice_label' => 'name']);

    }
}