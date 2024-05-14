<?php

namespace App\Test\Entity\UnitTest;

use App\Entity\Client;
use PHPUnit\Framework\TestCase;

class ClientEntityTest extends TestCase
{
    public function testGetterSetterNom(): void
    {
        $clientEntity = new Client();
        $clientEntity->setNom("uasoa");

        $this->assertSame("uasoa", $clientEntity->getNom());

    }

    public function testGetterSetterPrenom(): void
    {
        $clientEntity = new Client();
        $clientEntity->setPrenom("Rasoa");

        $this->assertEquals("Rasoa", $clientEntity->getPrenom());

    }

    public function testGetterSetterAdresse(): void
    {
        $clientEntity = new Client();
        $clientEntity->setAdresse("Rasoa");

        $this->assertEquals("Rasoa", $clientEntity->getAdresse());

    }
}