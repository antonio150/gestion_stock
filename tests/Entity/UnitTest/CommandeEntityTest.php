<?php

namespace App\Test\Entity\UnitTest;

use App\Entity\Commande;
use App\Entity\Produit;
use PHPUnit\Framework\TestCase;

class CommandeEntityTest extends TestCase
{
    public function testGetterSetterProduit()
    {
        $commande = new Commande() ;
        $produit = new Produit();
        $commande->addProduit($produit) ;

        $this->assertTrue($commande->getProduit()->contains($produit));
        
    }

    public function testGetterSetterQuantiteCommande()
    {
        $commande = new Commande() ;
        $commande->setQuantiteCommande(5) ;
        $this->assertSame(5, $commande->getQuantiteCommande());
    }
}