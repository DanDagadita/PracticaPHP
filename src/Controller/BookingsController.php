<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingsController extends AbstractController
{
    #[Route('/bookings', name: 'app_bookings')]
    public function index(ManagerRegistry $doctrine): Response
    {
        if (!$this->getUser()) { return $this->redirectToRoute('app_home'); }

        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $this->getUser()->getUserIdentifier()]);
        $bookings = $entityManager->getRepository(Booking::class)->findBy(['car' => $user->getCar()]);
        return $this->render('bookings/index.html.twig', [
            'controller_name' => 'BookingsController',
            'bookings' => $bookings,
        ]);
    }
}
