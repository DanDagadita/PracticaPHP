<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Car;
use App\Entity\Station;
use App\Form\BookingType;
use DateInterval;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    #[Route('/booking/{booking_id}', name: 'app_booking')]
    public function index(Request $request, $booking_id, ManagerRegistry $doctrine): Response
    {
        $booking = new BookingType();
        $entityManager = $doctrine->getManager();
        $booking_object = new Booking();
        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $booking_data_end_hours = $form->get('duration')->getData();
            $booking_data_end = $form->get('startDateTime')->getData();
            $booking_data_end->add(DateInterval::createFromDateString($booking_data_end_hours . ' hours'));
            $booking_data_start = $form->get('startDateTime')->getData();
            dd($booking_data_start, $booking_data_end);
            $booking_object->setChargeStart($booking_data_start);
            $booking_object->setChargeEnd($booking_data_end);

            $cars = $doctrine->getRepository(Car::class)->findAll();
            $booking_object->setCar($cars[0]);
            $stations = $doctrine->getRepository(Station::class)->findBy(['id' => $booking_id]);

            $booking_object->setStation($stations[0]);
            $entityManager->persist($booking_object);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->renderForm('booking/index.html.twig', [
            'form' => $form,
            'booking_id' => $booking_id
        ]);
    }
}
