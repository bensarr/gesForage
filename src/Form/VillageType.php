<?php

namespace App\Form;

use App\Entity\Village;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VillageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,array('label'=>'Nom','attr'=>array('class'=>'form-control form-group')))
            ->add('chef',ChefType::class,array('label'=>'Chef','attr'=>array('class'=>'form-control form-group')))
            ->add('Enregistrer',SubmitType::class,array('attr'=>array('class'=>'btn btn-dark form-group')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Village::class,
        ]);
    }
}
