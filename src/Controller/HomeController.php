<?php

namespace App\Controller;

use App\Entity\Station;
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
        $stations = $doctrine->getRepository(Station::class)->findAllStations();
        $locations = $doctrine->getRepository(Location::class)->findAll();
        $cities = ['Any' => 'Any'];
        for ($i = 0; $i < count($locations); $i++) {
            $city_name = $locations[$i]->getCity();
            $cities[$city_name] = $city_name;
        }
        $filter = new FilterType();
        $form = $this->createForm(FilterType::class, $filter, ['cities' => $cities]);

        $form->handleRequest($request);

        $city = 'Any'; $type = 'Any';
        if ($form->isSubmitted() && $form->isValid()) {
            $city = $form->get('city')->getData();
            $type = $form->get('type')->getData();
        }

        $type1 = []; $type2 = []; $total_types = [];
        $type1[0] = 0; $type2[0] = 0;
        $found = false;
        $location_index = 0;
        for ($s = 1; $s < count($stations); $s++) {
            if ($stations[$s]['location']['id'] === $stations[$s - 1]['location']['id'] && ($s !== count($stations) - 1)) {
                if ($stations[$s]['type'] === 'Type 1') {
                    $type1[$location_index]++;
                }
                else {
                    $type2[$location_index]++;
                }
                if ($stations[$s]['type'] === $type){
                    $found = true;
                }
            }
            else {
                $total_types[$location_index] = $type1[$location_index] + $type2[$location_index];

                if ((!$found && $type !== 'Any') || ($city !== $locations[$location_index]->getCity() && $city !== 'Any')) {
                    unset($locations[$location_index]);
                    unset($type1[$location_index]);
                    unset($type2[$location_index]);
                    unset($total_types[$location_index]);
                }
                if ($s !== count($stations) - 1) {
                    $location_index++;
                    $type1[$location_index] = 0;
                    $type2[$location_index] = 0;
                }
                $found = false;
            }
        }
        $locations = array_values($locations);
        $type1 = array_values($type1);
        $type2 = array_values($type2);
        $total_types = array_values($total_types);

        //dd($total_types, $type1, $type2);
        /*dd($total_types);

        for ($i = 0; $i < count($locations); $i++) {
            $type1[$i] = 0; $type2[$i] = 0;
            $found = false;
            $current_stations = [];
            for ($s = 0; $s < count($stations); $s++) {
                if ($stations[$s]['location']['id'] == $locations[$i]->getId()) {
                    $current_stations[$i] = $stations[$s];
                }
            }

            for ($j = 0; $j < count($current_stations); $j++) {
                if ($current_stations[$j]['type'] === $type) {
                    $found = true;
                }
                if ($current_stations[$j]['type'] === 'Type 1') {
                    $type1[$i]++;
                }
                else {
                    $type2[$i]++;
                }
            }
            if (!$found && $type !== 'Any') {
                unset($locations[$i]);
            }
            $total_types[$i] = $type1[$i] + $type2[$i];
        }*/

        return $this->renderForm('home/index.html.twig', [
            'locations' => $locations,
            'form' => $form,
            'type1arr' => $type1,
            'type2arr' => $type2,
            'total_typesarr' => $total_types
        ]);

    }
}
