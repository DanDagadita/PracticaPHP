<?php

namespace App\Controller;

use App\Form\EditBookingType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingEditController extends AbstractController
{
    #[Route('/booking/edit/{booking_id}', name: 'app_booking_edit')]
    public function index($booking_id, Request $request): Response
    {
        $edit = new EditBookingType();
        $form = $this->createForm(EditBookingType::class, $edit);

        $form->handleRequest($request);
        return $this->renderForm('booking_edit/index.html.twig', [
            'booking_id' => $booking_id,
            'form' => $form,
        ]);
    }
}
