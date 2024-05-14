<?php

namespace App\Controller\UnitTest;

use App\Controller\ClientController;
use App\Repository\ClientRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ClientControllerTest extends WebTestCase
{
    public function testIndexClient()
    {
        $client = static::createClient();
        $client->request("GET","/client");
        $this->assertResponseIsSuccessful();
    
    }

    public function testAjoutClient()
    {
        $client = static::createClient();
        $client->request("GET","/ajout_client");
        $this->assertResponseIsSuccessful();
    }

    public function testEditClient()
    {
        $client = static::createClient();
        $client->request("GET","/edit_client");
        $this->assertResponseIsSuccessful();
    }

    public function testDeleteClient()
    {
        $client = static::createClient();
        $client->request("POST","/delete_client");
        $this->assertResponseIsSuccessful();
    }
}