<?php

namespace App\Form;

use App\Entity\Payment;
use App\Entity\ParkingSpot;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $monthYearChoices = [];
        $currentYear = (int) date('Y');
        for ($year = $currentYear; $year <= $currentYear + 0; $year++) {
            for ($month = 1; $month <= 12; $month++) {
                $monthYearString = sprintf('%02d-%d', $month, $year);
                $monthYearChoices[$monthYearString] = $monthYearString;
            }
        }

        $builder
            ->add('owner')
            ->add('vehicle')
            ->add('paymentMethod', ChoiceType::class, [
                'choices' => [
                    'DebitCard' => 'DebitCard',
                    'CreditCard' => 'CreditCard',
                    'PayPal' => 'PayPal',
                    'TnG E-Wallet' => 'TnG E-Wallet',
                ],
                'placeholder' => 'Choose a Payment Method',
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Pending' => 'Pending',
                    'Successful' => 'Successful',
                    'Overdue' => 'Overdue',
                ],
                'placeholder' => 'Choose a Status',
            ])
            ->add('monthYear', ChoiceType::class, [
                'choices' => $monthYearChoices,
                'placeholder' => 'Choose a Month and Year',
            ])
            ->add('amount', null, [
                'attr' => ['readonly' => true]
            ])
            ->add('parkingSpot', EntityType::class, [
                'class' => ParkingSpot::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose a Parking Slot',
                'choice_attr' => function(ParkingSpot $parkingSpot, $key, $value) {
                    // the $parkingSpot object will have your entity, so you can get the ID like
                    return ['data-id' => $parkingSpot->getId()];
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Payment::class,
        ]);
    }
}
