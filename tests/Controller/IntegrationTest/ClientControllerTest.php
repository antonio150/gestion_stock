<?php

namespace App\Test\Controller\IntegrationTest;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClientControllerTest extends WebTestCase
{
    public function testIntegrationClient()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/ajout_client');

        $form = $crawler->selectButton('Save')->form([
            'client[nom]' => 'value',
            'client[prenom]' => 'value',
            'client[adresse]' => 'value',
        ]);
        $client->submit($form);
        // Assert that the response status code is 200
        $this->assertSame(302, $client->getResponse()->getStatusCode());

       
        
    }
}
