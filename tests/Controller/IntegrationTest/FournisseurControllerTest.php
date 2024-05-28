<?php

namespace App\Test\Controller\IntegrationTest;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FournisseurControllerTest extends WebTestCase
{
    public function testIntegrationFournisseur()
    {
        $fournisseur  = static::createClient();
        $crawler = $fournisseur->request('GET', '/fournisseur/ajout');

        $form = $crawler->selectButton('Submit')->form([
            'fournisseur[nom]' => 'value',
            'fournisseur[type]' => 'value',
            'fournisseur[adresse]' => 'value',
        ]);
        $fournisseur->submit($form);
        // Assert that the response status code is 200
        $this->assertSame(302, $fournisseur->getResponse()->getStatusCode());
    }
}
