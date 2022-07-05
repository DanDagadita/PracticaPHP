<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('time', TimeType::class, [
                'label' => 'Choose a booking time: ',
                'input'  => 'datetime',
                'widget' => 'choice',
                'mapped' => false,
            ])
            ->add('date', DateType::class, [
                'label' => 'Choose a booking date: ',
                'widget' => 'choice',
                'mapped' => false,
            ])
            ->add('duration', ChoiceType::class, [
                'label' => 'Choose a duration: ',
                'mapped' => false,
                'choices' => [
                    '1 hour' => 1,
                    '2 hours' => 2,
                    '3 hours' => 3
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Submit'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
