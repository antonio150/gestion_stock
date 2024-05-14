<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $client = new Client();
        $faker = Factory::create();
        $client->setNom('dada');
        $client->setPrenom('sasa');
        $client->setAdresse('tanan');

        $manager->persist($client);
        $manager->flush();
    }
}
