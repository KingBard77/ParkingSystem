<?php

namespace App\Controller;

use App\Entity\Payment;
use App\Entity\ParkingSpot; // Add this if ParkingSpot is an entity
use App\Form\PaymentType;
use App\Repository\PaymentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse; // Add this if you're using JsonResponse
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/payment')]
class PaymentController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    #[Route('/', name: 'app_payment_index', methods: ['GET'])]
    public function index(PaymentRepository $paymentRepository): Response
    {
        return $this->render('payment/index.html.twig', [
            'payments' => $paymentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_payment_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $payment = new Payment();
        $form = $this->createForm(PaymentType::class, $payment);
        $form->handleRequest($request);
    
        $rate = null;
        if ($form->isSubmitted() && $form->isValid()) {
            $parkingSpot = $form->get('parkingSpot')->getData();
            $payment->setParkingSpot($parkingSpot);
        
            if ($parkingSpot) {
                $rate = $parkingSpot->getRate();
                $payment->calculateAmount();  // Explicitly call the method
            }
        
            $payment->setPaymentDate(new \DateTime('now'));
            $this->entityManager->persist($payment);
            $this->entityManager->flush();
        
            return $this->redirectToRoute('app_payment_index', [], Response::HTTP_SEE_OTHER);
        } else {
            $rate = $payment->getParkingSpot() ? $payment->getParkingSpot()->getRate() : null;
        }
    
        // ... inside your edit function, just before rendering the template
        // $rate = $payment->getParkingSpot() ? $payment->getParkingSpot()->getRate() : null;
        // $amount = $payment->getAmount();

        return $this->render('payment/edit.html.twig', [
            'payment' => $payment,
            'form' => $form->createView(),
            // 'rate' => $rate,
            // 'amount' => $amount
        ]);
    }
    

    #[Route('/{id}', name: 'app_payment_show', methods: ['GET'])]
    public function show(Payment $payment): Response
    {
        
        return $this->render('payment/show.html.twig', [
            'payment' => $payment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_payment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Payment $payment): Response
    {
        $form = $this->createForm(PaymentType::class, $payment);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $parkingSpot = $form->get('parkingSpot')->getData();
            $payment->setParkingSpot($parkingSpot);
            
            // Explicitly call the calculateAmount method
            $payment->calculateAmount();
    
            // Use the already injected EntityManager to flush changes
            $this->entityManager->flush();
    
            return $this->redirectToRoute('app_payment_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('payment/edit.html.twig', [
            'payment' => $payment,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_payment_delete', methods: ['POST'])]
    public function delete(Request $request, Payment $payment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$payment->getId(), $request->request->get('_token'))) {
            $entityManager->remove($payment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_payment_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/get-rate/{id}', name: 'get_rate', methods: ['GET'])]
    public function getRate($id)
    {
        $parkingSpot = $this->entityManager->getRepository(ParkingSpot::class)->find($id);

        if ($parkingSpot) {
            return new JsonResponse(['rate' => $parkingSpot->getRate()]);
        } else {
            return new JsonResponse(['error' => 'Parking spot not found'], 404);
        }
    }
}
