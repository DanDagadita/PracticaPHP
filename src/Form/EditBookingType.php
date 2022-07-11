<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditBookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startDateTime', DateTimeType::class, [
            'label' => 'Choose a booking date: ',
            'mapped' => false,
            'widget' => 'single_text',
            'placeholder' => [
                'year' => date('Y'), 'month' => date('F'), 'day' => date('j'),
                'hour' => date('H'), 'second' => '00',
            ]
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
        ]);
    }
}
