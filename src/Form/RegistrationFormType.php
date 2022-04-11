<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'label' => "Votre email",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut pas être vide',
                    ]),
                ],
                'attr' =>[
                    'placeholder' => "Saisir votre email"
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => "Votre prénom",
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Le prénom doit contenir au moins 2 caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 30,
                    ]),                    new NotBlank([
                        'message' => 'Ce champ ne peut pas être vide',
                    ]),
                    ],
                'attr' =>[
                    'placeholder' => "Saisir votre prénom"
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => "Votre nom",
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Le nom doit contenir au moins 2 caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 80,
                    ]),
                    new NotBlank([
                        'message' => 'Ce champ ne peut pas être vide',
                    ]),
                ],
                'attr' =>[
                    'placeholder' => "Saisir votre prénom"
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new NotBlank(),
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('password', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe sont différents',

                'required'=> true,
                'first_options' => ['label' => "Mot de passe",
                    'attr' =>[
                        'placeholder' => "Saisir votre mot de passe"
                    ]],
                'second_options' => ['label' => "Confirmation mot de passe",
                    'attr' =>[
                    'placeholder' => "Confirmez votre mot de passe"
                ]],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Le mot de passe doit contenir au moins 6 caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 80,
                    ]),
                ],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
