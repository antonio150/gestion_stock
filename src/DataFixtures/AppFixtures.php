<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Fournisseur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $faker = Factory::create();
        for ($i = 0; $i < 10; ++$i) {
            $client = new Fournisseur();
            $client->setNom('nom'.$i);
            $client->setType('type'.$i);
            $client->setAdresse('adresse'.$i);

            $manager->persist($client);
            $manager->flush();
        }
    }
}
