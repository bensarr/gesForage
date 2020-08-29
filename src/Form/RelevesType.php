<?php

namespace App\Form;

use App\Entity\Compteur;
use App\Entity\Releve;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RelevesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date',DateType::class,array('label'=>'Date du Relevé','attr'=>array('class'=>'form-control form-group')))
            ->add('valeurEnChiffre',TextType::class,array('label'=>'Relevé En Chiffre','attr'=>array('class'=>'form-control form-group')))
            ->add('valeurEnLettre',TextType::class,array('label'=>'Relevé En Lettre','attr'=>array('class'=>'form-control form-group')))
            ->add('Enregistrer',SubmitType::class,array('attr'=>array('class'=>'btn btn-dark form-group')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Releve::class,
        ]);
    }
}
