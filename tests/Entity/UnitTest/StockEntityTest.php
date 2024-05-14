<?php

namespace Tests\Entity\UnitTest;

use App\Entity\Produit;
use App\Entity\Stock;
use PHPUnit\Framework\TestCase;

class StockEntityTest extends TestCase
{
    public function testGetterSetterProduit()
    {
        $stock = new Stock() ;
        $produit = new Produit();
        $stock->addProduit($produit);
        $this->assertTrue($stock->getProduit()->contains($produit));
    }

    public function testGetterSetterQuantiteStock()
    {
        $stock = new Stock() ;
        $stock->setQuantiteStock(5);
        $this->assertSame(5, $stock->getQuantiteStock());
    }

    public function testGetterGetterEmplacement()
    {
        $stock = new Stock() ;
        $stock->setEmplacement("test");
        $this->assertSame("test", $stock->getEmplacement());
    }

}