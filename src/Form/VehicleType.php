<?php

namespace App\Form;

use App\Entity\Vehicle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class VehicleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('licensePlate')
            ->add('brand', ChoiceType::class, [
                'choices' => [
                    'Audi' => 'Audi',
                    'BMW' => 'BMW',
                    'Mercedes' => 'Mercedes',
                    'Toyota' => 'Toyota',
                    'Ford' => 'Ford',
                    'Honda' => 'Honda',
                    'Nissan' => 'Nissan',
                    'Chevrolet' => 'Chevrolet',
                    'Volkswagen' => 'Volkswagen',
                    'Subaru' => 'Subaru',
                    'Mazda' => 'Mazda',
                    'Tesla' => 'Tesla',
                    'Volvo' => 'Volvo',
                    'Hyundai' => 'Hyundai',
                    'Jaguar' => 'Jaguar',
                    'Porsche' => 'Porsche',
                    'Ferrari' => 'Ferrari',
                ],
                'placeholder' => 'Choose a Brand',
            ])
            ->add('owner')
            ->add('parkingSpot')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicle::class,
        ]);
    }
}
