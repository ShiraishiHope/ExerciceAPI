<?php

namespace App\DataFixtures;

use App\Entity\Animal;
use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AnimalFixtures extends Fixture implements DependentFixtureInterface
{
    private const MARTIAL_ARTS = [
        'Skarate',
        'Judog',
        'Taekwhaledo',
        'Kong Fou',
        'Moo Thai',
        'Catboxing',
        'Capoeybara',
    ];
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $countries = $manager->getRepository(Country::class)->findAll();

        for ($i = 0; $i < 50; $i++) {
            $animal = new Animal();
            $animal->setName($faker->name);
            $animal->setAverageSize($faker->numberBetween(1, 100));
            $animal->setMartialArt($this->getRandomMartialArt());
            $animal->setPhoneNumber($faker->phoneNumber);

            $randomCountry = $faker->randomElement($countries);
            $animal->setCountry($randomCountry->getName());

            $manager->persist($animal);
        }

        $manager->flush();
    }
    private function getRandomMartialArt(): string
    {
        return self::MARTIAL_ARTS[array_rand(self::MARTIAL_ARTS)];
    }
    public function getDependencies()
    {
        return [
            CountryFixtures::class,
        ];
    }
}
