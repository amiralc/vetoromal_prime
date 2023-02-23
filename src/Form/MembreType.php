<?php

namespace App\Form;

use App\Entity\Membre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;


class MembreType extends AbstractType
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
            ->add('password', PasswordType::class, array(
                'attr' => array(
                    'placeholder' => 'Entrez votre mot passe', 'label' => 'Password'
                )))
            ->add('date_naiss')
            ->add('telephone', null, array(
                    'attr' => array(
                        'placeholder' => 'Entrez votre numero',
                    ))
            )
            ->add('adress', null, array(
                    'attr' => array(
                        'placeholder' => 'Entrez votre adresse',
                    ))
            )
            ->add('role', ChoiceType::class,[
                'required'=> true,
                'multiple'=> false,
                'expanded'=> false,
                'choices'=> [
                    'Patient'=> 'ROLE_USER',
                    'Veterinaire'=> 'ROLE_USER',
                    'Admin'=> 'ROLE_ADMIN',
                ],
            ])
            ->add('save', SubmitType::Class)

            /* ->add('produit')
             ->add('evenement')
             ->add('rendezvous')*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Membre::class,
        ]);
    }
}
