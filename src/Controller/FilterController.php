<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\FilterType;

class FilterController extends AbstractController
{
    #[Route('/filter', name: 'app_filter')]
    public function index(): Response
    {
        $filter = new FilterType();

        $form = $this->createForm(FilterType::class, $filter);

        return $this->renderForm('filter/index.html.twig', [
            'form' => $form,
        ]);
    }
}
