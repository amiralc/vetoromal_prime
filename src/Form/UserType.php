<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\CallbackTransformer;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('nom' , null, array(
                    'attr' => array(
                        'placeholder' => 'Entrez votre nom',
                    ))
            )
            ->add('prenom' , null, array(
                    'attr' => array(
                        'placeholder' => 'Entrez votre prenom',
                    ))
            )
            ->add('email' , null, array(
                'attr' => array(
                    'placeholder' => 'Entrez votre adresse mail',
                )))
            ->add('roles' , ChoiceType::class,[
        'required'=> true,
        'multiple'=> false,
        'expanded'=> false,
        'choices'=> [
            'User'=> 'ROLE_USER',
            'Admin'=> 'ROLE_ADMIN',
        ],
    ])
            ->add('num' , null, array(
                    'attr' => array(
                        'placeholder' => 'Entrez votre numero',
                    ))
            )

            ->add('password' , PasswordType::class, array(
                'attr' => array(
                    'placeholder' => 'Entrez votre mot passe', 'label' => 'Password'
                )))

            ->add('save', SubmitType::Class)
        ;
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($roleArray) {
                    return count($roleArray) ? $roleArray[0] : null;
                },
                function ($roleString) {
                    return [$roleString];
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
