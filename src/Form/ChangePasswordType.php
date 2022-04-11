<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled' => true

            ])
            ->add('firstname', TextType::class, [
                'disabled' => true,
                'label' => "Prénom"
            ])
            ->add('lastname', TextType::class, [
                'disabled' => true,
                'label' => "Nom"
            ])
            ->add('old_password', PasswordType::class, [
                'label' => "Mot de passe actuel",
                'mapped' => false,
                "attr" => [
                    'placeholder' => "Veuillez saisir votre mot de passe actuel"
                ]
            ])
            ->add('new_password', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe sont différents',
                'mapped' => false,
                'required'=> true,
                'first_options' => ['label' => "Nouveau mot de passe",
                    'attr' =>[
                        'placeholder' => "Saisir votre nouveau mot de passe"
                    ]],
                'second_options' => ['label' => "Confirmation nouveau mot de passe",
                    'attr' =>[
                        'placeholder' => "Confirmez votre nouveau mot de passe"
                    ]],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillir saisir un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Le mot de passe doit contenir au moins 6 caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 80,
                    ]),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Valider modification"
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
