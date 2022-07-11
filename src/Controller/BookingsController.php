<?php

namespace App\Controller;

use App\Entity\Booking;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingsController extends AbstractController
{
    #[Route('/bookings', name: 'app_bookings')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $bookings = $entityManager->getRepository(Booking::class)->findBy(['car' => 1]);
        return $this->render('bookings/index.html.twig', [
            'controller_name' => 'BookingsController',
            'bookings' => $bookings,
        ]);
    }
}
