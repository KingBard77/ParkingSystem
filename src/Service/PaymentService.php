<?php

namespace App\Service;

use App\Entity\Payment;
use App\Entity\ParkingSpot;
use App\Entity\PaymentDto;
use Doctrine\ORM\EntityManagerInterface;

class PaymentService
{
    // Existing method to create a payment based on a parking spot
    public function createPaymentWithParkingSpot(ParkingSpot $parkingSpot): Payment
    {
        $payment = new Payment();
        $payment->setParkingSpot($parkingSpot);
        
        $rate = $parkingSpot->getRate();
        $amount = $rate * 30; // Multiply by 30 as per your requirement
        $payment->setAmount($amount);
        
        return $payment;
    }

    // New method using PaymentDto
    public function createPayment(PaymentDto $paymentDto, ParkingSpot $parkingSpot): Payment
    {
        $payment = new Payment();
        $payment->setParkingSpot($parkingSpot);
        
        // ... set other fields from the DTO as necessary

        // Since you already have a lifecycle callback, the line below is not strictly necessary
        // $payment->calculateAmount();

        return $payment;
    }
}
