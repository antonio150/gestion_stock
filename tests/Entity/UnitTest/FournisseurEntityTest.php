<?php

namespace App\Test\Entity\UnitTest;
use App\Entity\Fournisseur;
use PHPUnit\Framework\TestCase;

class FournisseurEntityTest extends TestCase
{
    public function testGetterSetterNom()
    {
        $fournisseur = new Fournisseur();
        $fournisseur->setNom("Sasa");
        $this->assertSame("Sasa", $fournisseur->getNom());
    }

    public function testGetterSetterType()
    {
        $fournisseur = new Fournisseur();
        $fournisseur->setType("Test");

        $this->assertSame("Test", $fournisseur->getType());
    }

    public function testGetterSetterAdresse()
    {
        $fournisseur = new Fournisseur();
        $fournisseur->setAdresse("Tana");
        $this->assertSame("Tana", $fournisseur->getAdresse());
    }
}