<?php

namespace App\Test\Entity\IntegrationTest;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use App\Service\ProduitService;
use PHPUnit\Framework\TestCase;

class ProduitTest extends TestCase
{
    public function testGetAllProduit()
    {
        $mockRepository = $this->createMock(ProduitRepository::class);
        $mockRepository->expects($this->any())
        ->method('findAll')
        ->willReturn([new Produit()]);

        $produitService = new ProduitService($mockRepository);

        $produit = new ProduitService($mockRepository);

        $produit = $produitService->getAllProduit();

        $this->assertCount(1, $produit);
    }
}