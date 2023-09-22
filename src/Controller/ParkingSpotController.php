<?php

namespace App\Controller;

use App\Entity\ParkingSpot;
use App\Form\ParkingSpotType;
use App\Repository\ParkingSpotRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/parking/spot')]
class ParkingSpotController extends AbstractController
{
    #[Route('/', name: 'app_parking_spot_index', methods: ['GET'])]
    public function index(ParkingSpotRepository $parkingSpotRepository): Response
    {
        return $this->render('parking_spot/index.html.twig', [
            'parking_spots' => $parkingSpotRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_parking_spot_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $parkingSpot = new ParkingSpot();
        $form = $this->createForm(ParkingSpotType::class, $parkingSpot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($parkingSpot);
            dump($parkingSpot);
            $entityManager->flush();

            return $this->redirectToRoute('app_parking_spot_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('parking_spot/new.html.twig', [
            'parking_spot' => $parkingSpot,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_parking_spot_show', methods: ['GET'])]
    public function show(ParkingSpot $parkingSpot): Response
    {
        return $this->render('parking_spot/show.html.twig', [
            'parking_spot' => $parkingSpot,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_parking_spot_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ParkingSpot $parkingSpot, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ParkingSpotType::class, $parkingSpot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_parking_spot_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('parking_spot/edit.html.twig', [
            'parking_spot' => $parkingSpot,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_parking_spot_delete', methods: ['POST'])]
    public function delete(Request $request, ParkingSpot $parkingSpot, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$parkingSpot->getId(), $request->request->get('_token'))) {
            $entityManager->remove($parkingSpot);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_parking_spot_index', [], Response::HTTP_SEE_OTHER);
    }

    // #[Route('/api/rate/{id}', name: 'app_parking_spot_rate', methods: ['GET'])]
    // public function getRate(ParkingSpot $parkingSpot): JsonResponse
    // {
    //     return new JsonResponse(['rate' => $parkingSpot->getRate()]);
    // }
}
