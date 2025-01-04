<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FournisseurControllerTest extends WebTestCase
{
    public function testAjoutFournisseur(): void
    {
        // Créer un client pour simuler un navigateur
        $client = static::createClient();

        // Naviguer vers la page contenant le formulaire
        $crawler = $client->request('GET', '/fournisseur/ajout');

        // Vérifiez que la requête a réussi
        $this->assertResponseIsSuccessful();

        // Récupérer le formulaire par le bouton "Submit"
        $form = $crawler->selectButton('Submit')->form([
            'fournisseur[nom]' => 'Test Fournisseur',
            'fournisseur[type]' => 'Test Type',
            'fournisseur[adresse]' => '123 Rue Exemple',
        ]);

        // Soumettre le formulaire
        $client->submit($form);

        // Vérifiez la redirection après soumission
        $this->assertResponseRedirects('/fournisseur'); // Modifié pour correspondre à la réalité

        // Suivre la redirection
        $client->followRedirect();

        // Vérifiez que la page contient le fournisseur ajouté
        $this->assertSelectorTextContains('.fournisseur-nom', 'Test Fournisseur');
    }

}
