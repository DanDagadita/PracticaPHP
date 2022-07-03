<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', ChoiceType::class, [
                'label' => 'Choose a city: ',
                'mapped' => false,
                'choices' => $options['cities']
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Choose a type: ',
                'mapped' => false,
                'choices' => [
                    'Any' => 'Any',
                    'Type 1' => 'Type 1',
                    'Type 2' => 'Type 2'
                ]
            ])
            ->add('submit', SubmitType::class, array(
                'label' => 'Filter'
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'cities' => ['Any' => 'Any']
        ]);
    }
}
