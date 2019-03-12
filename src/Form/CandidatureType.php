<?php

namespace App\Form;


use App\Entity\Offre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CandidatureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', TextType::class, array('label' => 'nom :'))
        ->add('firstname', TextType::class, array('label' => 'prenom :'))
        ->add('email', TextType::class, array('label' => 'email :'))
        ->add('cv', TextType::class, array('label' => 'cv :'))
        ->add('offre', EntityType::class, ['class' => Offre::class, 'choice_label' => 'title']);
    }
}