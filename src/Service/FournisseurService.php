<?php

namespace App\Service;

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
     * @return array<array<string,mixed>>
     */
    public function getAllFournisseur(): array
    {
        return $this->fournisseurRepository->getAll();
    }
}
