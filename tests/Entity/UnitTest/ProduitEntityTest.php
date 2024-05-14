<?php

namespace Tests\Entity\UnitTest;

use App\Entity\Fournisseur;
use App\Entity\Produit;
use PHPUnit\Framework\TestCase;

class ProduitEntityTest extends TestCase
{
    public function testGetterSetterNom()
    {
        $produit = new Produit();
        $produit->setNom("Test");
        $this->assertSame("Test", $produit->getNom());
    }

    public function testGetterSetterDescription()
    {
        $produit = new Produit();
        $produit->setDescription("sasa sasa sasa");
        $this->assertSame("sasa sasa sasa", $produit->getDescription());
    }

    public function testGetterSetterPrixUnit()
    {
        $produit = new Produit();
        $produit->setPrixUnit(8);
        $this->assertSame(8, $produit->getPrixUnit());
    }

    public function testGetterSetterFournisseur()
    {
        $produit = new Produit();
        $fournisseur = new Fournisseur();

        $produit->setFournisseur($fournisseur);
        $this->assertSame($fournisseur, $produit->getFournisseur());
    }
}