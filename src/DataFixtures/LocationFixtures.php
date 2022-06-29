<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Location;
use App\Entity\Station;

class LocationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++)
        {
            $location = new Location();

            $total_spots = rand(10, 30);
            $location->setName("Location ". $i);
            $location->setTotalSpots($total_spots);
            $location->setLatitude(45.75 + rand(-150, 150) / 100);
            $location->setLongitude(25.0 + rand(-350, 350) / 100);
            $location->setPrice(rand(10, 30) / 10);

            for ($stations_iterator = 1; $stations_iterator <= $total_spots; $stations_iterator++)
            {
                $station = new Station();

                $station->setLocation($location);
                $station->setType("Type ". rand(1, 2));
                $station->setPower(rand(100, 200) / 10);
                $manager->persist($station);
            }

            $manager->persist($location);
            $manager->flush();
        }
    }
}
