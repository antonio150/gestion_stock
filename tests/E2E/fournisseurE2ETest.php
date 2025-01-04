<?php

namespace App\Tests\E2E;

use Symfony\Component\Panther\PantherTestCase;

class FournisseurEndToEndTest extends PantherTestCase
{
    public function testAjoutFournisseur(): void
    {
        // 1. Démarrez un client Panther (navigateur)
        $client = self::createPantherClient([], [
            'webServerDir' => __DIR__ . '/../public',
            'browser' => PantherTestCase::CHROME,
            'devtools' => true, // Désactive les DevTools
            'headless' => true,  // Mode headless
        ]);

        // 2. Accédez à la page d'ajout de fournisseur
        $crawler = $client->request('GET', '/fournisseur/ajout');

        // 3. Vérifiez que la page contient le bon titre
        // $this->assertSelectorTextContains('h1', 'Ajouter un Fournisseur');

        $this->assertSelectorExists('form', 'Le formulaire est introuvable sur la page.');

        // 4. Remplissez le formulaire
        $form = $crawler->filter('button[type="submit"]')->form([
            'fournisseur[nom]' => 'Test Fournisseur',
            'fournisseur[type]' => 'Test Type',
            'fournisseur[adresse]' => '123 Rue Exemple',
        ]);

        // 5. Soumettez le formulaire
        $client->submit($form);

        // 6. Vérifiez que vous êtes redirigé vers la liste des fournisseurs
        $this->assertStringContainsString('/fournisseur', $client->getCurrentURL());

        // 7. Vérifiez que le fournisseur apparaît dans la liste
        $this->assertSelectorTextContains('.fournisseur-nom', 'Tsiry');
    }
}
