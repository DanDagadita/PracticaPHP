<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Car;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingDeleteController extends AbstractController
{
    #[Route('/booking/delete/{booking_id}', name: 'app_booking_delete')]
    public function index($booking_id, ManagerRegistry $doctrine): Response
    {
        if (!$this->getUser()) { return $this->redirectToRoute('app_home'); }

        $found = false;
        $entityManager = $doctrine->getManager();
        $booking = $entityManager->getRepository(Booking::class)->findOneBy(['id' => $booking_id]);
        if ($booking)
        {
            $car = new Car();
            $booking->setCar($car);
            $entityManager->remove($booking);
            $entityManager->flush();
            $found = true;
        }

        return $this->render('booking_delete/index.html.twig', [
            'booking_id' => $booking_id,
            'found' => $found,
        ]);
    }
}
