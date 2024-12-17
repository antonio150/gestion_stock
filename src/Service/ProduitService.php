<?php

namespace App\Service;

use App\Entity\Produit;
use App\Repository\ProduitRepository;

class ProduitService
{
    /**
     * @var ProduitRepository
     */
    private $produitRepository;

    public function __construct(ProduitRepository $produitRepository)
    {
        $this->produitRepository = $produitRepository;
    }

    /**
     * @return Produit[]
     */
    public function getAllProduit(): array
    {
        return $this->produitRepository->findAll();
    }
}
