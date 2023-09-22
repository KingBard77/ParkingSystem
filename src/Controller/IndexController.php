<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ParkingSpotRepository;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('page/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('page/about.html.twig', [
            'controller_name' => 'AboutController',
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('page/contact.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }

    #[Route('/parking', name: 'app_parking')]
    public function parking(ParkingSpotRepository $parkingSpotRepository): Response
    {
        $parkingSpots = $parkingSpotRepository->findAll();
    
        return $this->render('page/parking.html.twig', [
            'parkingSpots' => $parkingSpots,
        ]);
    }
}
