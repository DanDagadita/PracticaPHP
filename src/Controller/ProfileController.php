<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(ManagerRegistry $doctrine): Response
    {
        if (!$this->getUser()) { return $this->redirectToRoute('app_home'); }

        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $this->getUser()->getUserIdentifier()]);
        return $this->render('profile/index.html.twig', [
            'user' => $user,
        ]);
    }
}
