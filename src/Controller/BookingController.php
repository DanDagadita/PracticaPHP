<?php

namespace App\Controller;

use App\Form\BookingType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    #[Route('/booking', name: 'app_booking')]
    public function index(Request $request): Response
    {
        $booking = new BookingType();

        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $booking_data = $form->getData();

            return $this->redirectToRoute('app_home');
        }

        $booking_id = $_GET["id"];
        return $this->renderForm('booking/index.html.twig', [
            'form' => $form,
            'booking_id' => $booking_id
        ]);
    }
}
