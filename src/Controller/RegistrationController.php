<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, AuthenticationUtils $authenticationUtils): Response
    {
        $user = new User();
        $lastUsername = $authenticationUtils->getLastUsername();
        $form = $this->createForm(RegistrationType::class, $user, ['last_username' => $lastUsername]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setEmail($form->get('email')->getData());
            $user->setCity($form->get('city')->getData());
            $user->setName($form->get('first_name')->getData() . ' ' . $form->get('last_name')->getData());
            $car = new Car();
            $car->setChargerType($form->get('charger_type')->getData());
            $car->setLicensePlate($form->get('license_plate')->getData());
            $car->setUser($user);
            $user->setCar($car);
            $entityManager->persist($car);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
