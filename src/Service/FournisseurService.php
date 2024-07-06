<?php

namespace App\Service;

use App\Entity\Fournisseur;
use App\Repository\FournisseurRepository;

class FournisseurService
{
    /**
     * @var FournisseurRepository
     */
    private $fournisseurRepository;

    public function __construct(FournisseurRepository $fournisseurRepository)
    {
        $this->fournisseurRepository = $fournisseurRepository;
    }

    /**
     * @return Fournisseur[]
     */
    public function getAllFournisseur(): array
    {
        return $this->fournisseurRepository->getAll();
    }
}
