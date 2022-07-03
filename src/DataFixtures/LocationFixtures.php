<?php

namespace App\DataFixtures;

use App\Entity\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Location;
use App\Entity\Station;

class LocationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $ro_locations = $manager->getRepository(City::class, 'db_ro')->findAll();
        for ($i = 0; $i < 15; $i++) {
            $city_name = $ro_locations[$i]->getCity();
            $city_latitude = $ro_locations[$i]->getLatitude();
            $city_longitude = $ro_locations[$i]->getLongitude();

            for ($j = 2; $j <= 6; $j++) {
                $location = new Location();
                $total_spots = rand(10, 30);
                $has_only_one_charger_type = rand(0, 1);
                $unique_charger_type = rand(1, 2);
                $owner_first_names = ['Georgică', 'Gigel', 'Ion', 'Marcu', 'Marcel', 'Dănuț'];
                $owner_last_names = ['Popescu', 'Ionescu', 'Eminescu', 'Popovici', 'Tudor', 'Jianu'];
                $location->setName($owner_first_names[rand(0, count($owner_first_names) - 1)] . ' ' . $owner_last_names[rand(0, count($owner_last_names) - 1)] . "'s Charging Location");
                $location->setLatitude($city_latitude + rand(-3, 3) / 100);
                $location->setLongitude($city_longitude + rand(-3, 3) / 100);
                $location->setPrice(rand(10, 30) / 10);
                $location->setCity($city_name);

                for ($stations_iterator = 1; $stations_iterator <= $total_spots; $stations_iterator++) {
                    $station = new Station();

                    $station->setLocation($location);
                    if ($has_only_one_charger_type === 0)
                    {
                        $station->setType("Type " . rand(1, 2));
                    }
                    else
                    {
                        $station->setType("Type " . $unique_charger_type);
                    }
                    $station->setPower(rand(100, 200) / 10);
                    $manager->persist($station);
                }

                $manager->persist($location);
                $manager->flush();
            }
        }
    }
}
