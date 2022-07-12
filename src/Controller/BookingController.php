<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\BookingType;
use DateInterval;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    #[Route('/booking/{location_id}', name: 'app_booking')]
    public function index(Request $request, $location_id, ManagerRegistry $doctrine): Response
    {
        $booking = new BookingType();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $error = false;
            $found = true;
            $booking_data_end_hours = $form->get('duration')->getData();
            $booking_data_start = DateTimeImmutable::createFromMutable($form->get('startDateTime')->getData());
            $booking_data_end = $form->get('startDateTime')->getData();
            $booking_data_end->add(DateInterval::createFromDateString($booking_data_end_hours . ' hours'));
            $charger_type = $form->get('charger_type')->getData();
            if ($charger_type === 'Any') {
                $found_stations = $doctrine->getRepository(Booking::class)->findStationsByFilter($booking_data_start, $booking_data_end, $location_id);
            } else {
                $found_stations = $doctrine->getRepository(Booking::class)->findStationsByFilterType($booking_data_start, $booking_data_end, $location_id, $charger_type);
            }
            if (count($found_stations) === 0) {
                $error = true;
                $found = false;
            }

            return $this->renderForm('booking/index.html.twig', [
                'form' => $form,
                'location_id' => $location_id,
                'booking_error' => $error,
                'found_stations' => $found,
                'stations' => $found_stations,
                'booking_data_start' => $booking_data_start->format('U'),
                'booking_data_end' => $booking_data_end->format('U')
            ]);
        }

        return $this->renderForm('booking/index.html.twig', [
            'form' => $form,
            'location_id' => $location_id,
            'booking_error' => false,
            'found_stations' => false
        ]);
    }
}
