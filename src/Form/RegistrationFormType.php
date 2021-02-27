<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mail', TextType::class, array( 'attr' => array ( 'placeholder' => 'Email') ))
            ->add('pseudo', TextType::class,  array( 'attr' => array ( 'placeholder' => 'Pseudo') ) )
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les termes.',
                    ]),
                ],
            ])
            ->add('motDePasse', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux saisies doivent correspondre.',
                /*'mapped' => false,*/
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => false,'attr' =>['placeholder' => 'Nouveau mot de passe' ]],
                'second_options' =>  ['label' => false,'attr' =>['placeholder' => 'Retaper le mot de passe' ]],
                'constraints' => [
                    new NotBlank(['message' => 'Entrer le mot de passe.', ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit faire 8 caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                         ])
                        ]
                    ])  
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
