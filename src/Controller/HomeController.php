<?php

namespace App\Controller;

use App\Form\FilterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Location;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
        $locations = $doctrine->getRepository(Location::class)->findAll();
        $cities = ['Any' => 'Any'];
        for ($i = 0; $i < count($locations); $i++) {
            $city_name = $locations[$i]->getCity();
            $cities[$city_name] = $city_name;
        }
        $filter = new FilterType();
        $form = $this->createForm(FilterType::class, $filter, ['cities' => $cities]);

        $form->handleRequest($request);

        $city = 'Any';
        $type = 'Any';
        if ($form->isSubmitted() && $form->isValid()) {
            $city = $form->get('city')->getData();
            $type = $form->get('type')->getData();
        }

        if ($city !== 'Any') {
            $locations = $doctrine->getRepository(Location::class)->findBy(array('city' => $city));
        }

        if ($type !== 'Any') {
            for ($i = 0; $i < count($locations); $i++) {
                $stations = $locations[$i]->getStations();
                $found = false;
                for ($j = 0; $j < count($stations); $j++) {
                    if ($stations[$j]->getType() === $type) {
                        $found = true;
                    }
                }
                if (!$found) {
                    unset($locations[$i]);
                }
            }
        }

        return $this->renderForm('home/index.html.twig', [
            'locations' => $locations,
            'form' => $form,
        ]);

    }
}
