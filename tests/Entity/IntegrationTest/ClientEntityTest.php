<?php

namespace App\Test\Entity\IntegrationTest;

use App\Entity\Client;
use App\Repository\ClientRepository;
use App\Service\ClientService;
use PHPUnit\Framework\TestCase;

class ClientEntityTest extends TestCase
{
    public function testGetAllClient()
    {
        $mockRepository=$this->createMock(ClientRepository::class);
        $mockRepository->expects($this->any())
        ->method("findAll")
        ->willReturn([new Client(), new Client()]);

        $clientService=new ClientService($mockRepository);
        

        $client = $clientService->getAllClient();
     
        $this->assertCount(2, $client);
        // $this->assertInstanceOf(Client::class, $client[0]);
    }
}