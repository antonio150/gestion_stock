<?php

namespace App\DataFixtures;

use App\Entity\Fournisseur;
use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $faker = Factory::create();
        $this->fillProduit($manager);
    }

    /**
     * @return Fournisseur[]
     */
    public function fillFournisseur(ObjectManager $manager): array
    {
        $listeFournisseur = [];
        for ($i = 0; $i < 10; ++$i) {
            $fournisseur = new Fournisseur();
            $fournisseur->setNom('nom'.$i);
            $fournisseur->setType('type'.$i);
            $fournisseur->setAdresse('adresse'.$i);
            $listeFournisseur[] = $fournisseur;

            $manager->persist($fournisseur);
            $manager->flush();
        }

        return $listeFournisseur;
    }

    public function fillProduit(ObjectManager $manager): void
    {
        $fournisseur = $this->fillFournisseur($manager);
        $faker = Factory::create();
        for ($i = 0; $i < 10; ++$i) {
            $produit = new Produit();

            $produit->setNom($faker->name);
            $produit->setDescription($faker->lastName);
            $produit->setPrixUnit(100);
            $produit->setFournisseur($fournisseur[mt_rand(0, count($fournisseur) - 1)]);

            $manager->persist($produit);
            $manager->flush();
        }
    }
}
