<?php

namespace App\Form;

use App\Entity\Roles;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParameterUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class,array('label'=>'Identifiant','attr'=>array('class'=>'form-control form-group')))
            ->add('password', PasswordType::class,array('label'=>'Mot de passe','attr'=>array('class'=>'form-control form-group')))
            ->add('nom', TextType::class,array('label'=>'Nom','attr'=>array('class'=>'form-control form-group','readonly'=>'readonly')))
            ->add('prenom', TextType::class,array('label'=>'Prénom','attr'=>array('class'=>'form-control form-group','readonly'=>'readonly')))
            ->add('email', EmailType::class,array('label'=>'Email','attr'=>array('class'=>'form-control form-group','readonly'=>'readonly')))
            ->add('roles',EntityType::class,
                array(
                    'class'=>Roles::class,
                    'label'=>'Rôles',
                    'expanded'=>true,
                    'multiple'=> true,
                    'attr'=>array(
                        'class'=>'form-control form-group'
                    ),
                    'data'=>$options['mesroles']
                )
            )
            ->add('Enregistrer',SubmitType::class,array('attr'=>array('class'=>'btn btn-dark form-group')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
        $resolver->setRequired(array('mesroles'));
    }
}
