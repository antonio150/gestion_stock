<?php

namespace App\Service;

use App\Repository\ClientRepository;

class ClientService
{
    private $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function getAllClient()
    {
        return $this->clientRepository->findAll();
    }

    public function getClientById($id)
    {
        return $this->clientRepository->findOneById($id);
    }
}
