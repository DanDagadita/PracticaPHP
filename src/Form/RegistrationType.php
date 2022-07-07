<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('first_name', TextType::class, [
                'mapped' => false,
                'label' => 'First name: '
            ])
            ->add('last_name', TextType::class, [
                'mapped' => false,
                'label' => 'Last name: '
            ])
            ->add('email', TextType::class, [
                'mapped' => false,
                'label' => 'Email: ',
                'data' => $options['last_username']
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Password: ',
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('city', TextType::class, [
                'mapped' => false,
                'label' => 'City: '
            ])
            ->add('license_plate', TextType::class, [
                'mapped' => false,
                'label' => 'License plate: '
            ])
            ->add('charger_type', ChoiceType::class, [
                'label' => 'Choose a charger type: ',
                'mapped' => false,
                'choices' => [
                    'Type 1' => 'Type 1',
                    'Type 2' => 'Type 2'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Register'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'last_username' => '',
        ]);
    }
}
