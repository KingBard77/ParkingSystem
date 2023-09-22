<?php

namespace App\Form;

use App\Entity\ParkingSpot;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class ParkingSpotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name')
            ->add('Status', ChoiceType::class, [
                'choices' => [
                    'Available' => 'Available',
                    'Unavailable' => 'Unavailable',
                ],
                'placeholder' => 'Choose a Status',
            ])
            ->add('Type', ChoiceType::class, [
                'choices' => [
                    'Basic' => 'Basic',
                    'Standard' => 'Standard',
                    'Premium' => 'Premium',
                ],
                'placeholder' => 'Choose a Type',
            ])
            ->add('Zone', ChoiceType::class, [
                'choices' => [
                    'A' => 'A',
                    'B' => 'B',
                    'C' => 'C',
                    'D' => 'D',
                    'E' => 'E',
                ],
                'placeholder' => 'Choose a Zone',
            ])
            ->add('Rate', null, [
                'disabled' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ParkingSpot::class,
        ]);
    }
}
