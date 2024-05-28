<?php

namespace App\Service;

use App\Repository\ClientRepository;
use App\Repository\FournisseurRepository;

class FournisseurService
{
    private $fournisseurRepository;

    public function __construct(FournisseurRepository $fournisseurRepository)
    {
        $this->fournisseurRepository = $fournisseurRepository;
    }

    public function getAllFournisseur()
    {
        return $this->fournisseurRepository->getAll();
    }
}
