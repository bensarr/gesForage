<?php

namespace App\Form;

use App\Entity\Abonnement;
use App\Entity\Compteur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AbonnementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numero',TextType::class,array('label'=>'Numéro Abonnement','attr'=>array('class'=>'form-control form-group')))
            ->add('date',DateType::class,array('label'=>'Date Abonnement','attr'=>array('class'=>'form-control form-group')))
            ->add('client',ClientType::class,array('label'=>'Client','attr'=>array('class'=>'form-control form-group')))
            ->add('compteur',EntityType::class,array('class'=>Compteur::class,'label'=>'Village du client','attr'=>array('class'=>'form-control form-group')))
            ->add('Enregistrer',SubmitType::class,array('attr'=>array('class'=>'btn btn-dark form-group')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Abonnement::class,
        ]);
    }
}
