<?php

namespace App\Test\Entity\IntegrationTest;

use App\Entity\Fournisseur;
use App\Repository\FournisseurRepository;
use App\Service\FournisseurService;
use PHPUnit\Framework\TestCase;

class FournisseurEntityTest extends TestCase
{
    public function testGetAllClient()
    {
        $mockRepository = $this->createMock(FournisseurRepository::class);
        $mockRepository->expects($this->any())
            ->method('getAll')
            ->willReturn([new Fournisseur(), new Fournisseur()]);

        $fournisseurService = new FournisseurService($mockRepository);

        $fournisseur = $fournisseurService->getAllFournisseur();
        $this->assertCount(2, $fournisseur);
    }
}
