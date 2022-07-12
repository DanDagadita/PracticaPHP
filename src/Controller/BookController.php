<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Station;
use App\Entity\User;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/book/{station_id}/{booking_data_start}/{booking_data_end}', name: 'app_book')]
    public function index($station_id, $booking_data_start, $booking_data_end, ManagerRegistry $doctrine): Response
    {
        $booking_data_start = (new DateTime)->setTimestamp($booking_data_start);
        $booking_data_end = (new DateTime)->setTimestamp($booking_data_end);
        $entityManager = $doctrine->getManager();
        $booking_object = new Booking();
        $booking_object->setChargeStart($booking_data_start);
        $booking_object->setChargeEnd($booking_data_end);
        $current_user = $doctrine->getRepository(User::class)->findOneBy(['email' => $this->getUser()->getUserIdentifier()]);
        $car = $current_user->getCar();
        $booking_object->setCar($car);
        $station = $doctrine->getRepository(Station::class)->findOneBy(['id' => $station_id]);
        $booking_object->setStation($station);
        $entityManager->persist($booking_object);
        $entityManager->flush();

        return $this->render('book/index.html.twig', [
            'station_id' => $station_id,
            'booking_data_start' => $booking_data_start,
            'booking_data_end' => $booking_data_end
        ]);
    }
}
