<?php

namespace App\Form;

use App\Entity\Compteur;
use App\Entity\PropertySearch;
use App\Entity\Village;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numeroAbonnement',TextType::class,
                [
                    'required'=>false,
                    'label'=>false,
                    'attr'=>
                        [
                            'placeholder'=>'Numero Abonnement',
                            'class'=>'form-control'
                        ],
                ]
            )
            ->add('nomClient',TextType::class,
                [
                    'required'=>false,
                    'label'=>false,
                    'attr'=>
                        [
                            'placeholder'=>'Nom Client',
                            'class'=>'form-control '
                        ],
                ]
            )
            ->add('compteur',EntityType::class,
                [
                    'class'=>Compteur::class,
                    'required'=>false,
                    'label'=>false,
                    'attr'=>
                        [
                            'placeholder'=>'compteur',
                            'class'=>'form-control '
                        ],
                ]
            )
            ->add('village',EntityType::class,
                [
                    'class'=>Village::class,
                    'required'=>false,
                    'label'=>false,
                    'attr'=>
                        [
                            'placeholder'=>'Village',
                            'class'=>'form-control '
                        ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
        ]);
        $resolver->setDefaults([
        'data_class'=>PropertySearch::class,
        'method'=>'get',
        'csrf_protection'=>false
    ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
