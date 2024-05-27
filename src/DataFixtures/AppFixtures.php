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
        // $faker = Factory::create();
        for ($i = 0; $i < 10; ++$i) {
            $client = new Client();
            $client->setNom('Sasa'.$i);
            $client->setPrenom('Derz'.$i);
            $client->setAdresse('QAR'.$i);

            $manager->persist($client);
            $manager->flush();
        }
    }
}
