<?php

namespace App\Form;

use App\Entity\Compteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numero',TextType::class,array('label'=>'Numéro Compteur','attr'=>array('class'=>'form-control form-group')))
            //->add('etat',TextType::class,array('label'=>'Nom','attr'=>array('class'=>'form-control form-group')))
            ->add('Enregistrer',SubmitType::class,array('attr'=>array('class'=>'btn btn-dark form-group')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Compteur::class,
        ]);
    }
}
