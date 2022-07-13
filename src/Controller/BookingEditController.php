<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\User;
use App\Form\EditBookingType;
use DateInterval;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingEditController extends AbstractController
{
    #[Route('/booking/edit/{booking_id}', name: 'app_booking_edit')]
    public function index($booking_id, Request $request, ManagerRegistry $doctrine): Response
    {
        if (!$this->getUser()) { return $this->redirectToRoute('app_home'); }

        $edit = new EditBookingType();
        $form = $this->createForm(EditBookingType::class, $edit);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $booking = $entityManager->getRepository(Booking::class)->findOneBy(['id' => $booking_id]);
            $booking_data_end_hours = $form->get('duration')->getData();
            $booking_data_start = DateTimeImmutable::createFromMutable($form->get('startDateTime')->getData());
            $booking_data_end = $form->get('startDateTime')->getData();
            $booking_data_end->add(DateInterval::createFromDateString($booking_data_end_hours . ' hours'));
            $booking->setChargeStart($booking_data_start);
            $booking->setChargeEnd($booking_data_end);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->renderForm('booking_edit/index.html.twig', [
            'booking_id' => $booking_id,
            'form' => $form,
        ]);
    }
}
