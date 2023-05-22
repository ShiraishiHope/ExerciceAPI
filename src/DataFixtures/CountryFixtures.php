<?php

namespace App\DataFixtures;

use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

#[ORM\FixtureGroup("animal")]
class CountryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 195; $i++) {
            $country = new Country();
            $country->setName($faker->country);
            $country->setIso($faker->countryCode);

            $manager->persist($country);
        }

        $manager->flush();
    }
}
