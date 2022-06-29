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
            $station = new Station();

            $location->setName("Location ". $i);
            $location->setTotalSpots(rand(25, 80));
            $location->setLongitude(45.75 + rand(-200, 200) / 100);
            $location->setLatitude(25.0 + rand(-400, 400) / 100);
            $location->setPrice(rand(10, 30) / 10);

            $station->setLocation($location);
            $station->setType("Type ". rand(1, 2));
            $station->setPower(rand(100, 200) / 10);

            $manager->persist($location);
            $manager->persist($station);
            $manager->flush();
        }
    }
}
