<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Village;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,array('label'=>'Nom Client','attr'=>array('class'=>'form-control form-group')))
            ->add('tel',TextType::class,array('label'=>'Téléphone','attr'=>array('class'=>'form-control form-group')))
            ->add('adresse',TextType::class,array('label'=>'Adresse','attr'=>array('class'=>'form-control form-group')))
            ->add('village',EntityType::class,array('class'=>Village::class,'label'=>'Village du client','attr'=>array('class'=>'form-control form-group')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
