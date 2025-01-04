<?php

namespace App\Tests\Form;

use App\Entity\Fournisseur;
use App\Form\FournisseurType;
use Symfony\Component\Form\Test\TypeTestCase;

class FournisseurTypeTest extends TypeTestCase
{
    public function testSubmitValidData(): void
    {
        // Données simulées que l'utilisateur soumettrait via le formulaire
        $formData = [
            'nom' => 'Test Fournisseur',
            'type' => 'Test Type',
            'adresse' => '123 Rue Exemple',
        ];

        // Instanciation de l'entité liée au formulaire
        $fournisseur = new Fournisseur();

        // Création du formulaire avec la classe FournisseurType
        $form = $this->factory->create(FournisseurType::class, $fournisseur);

        // Simulation de la soumission du formulaire
        $form->submit($formData);

        // Vérifiez si le formulaire est valide
        $this->assertTrue($form->isSynchronized());

        

        // Vérification des valeurs des champs
        $this->assertSame('Test Fournisseur', $fournisseur->getNom());
        $this->assertSame('Test Type', $fournisseur->getType());
        $this->assertSame('123 Rue Exemple', $fournisseur->getAdresse());
    }

    public function testBuildFormStructure(): void
    {
        $form = $this->factory->create(FournisseurType::class);

        // Vérifiez que les champs existent dans le formulaire
        $this->assertTrue($form->has('nom'));
        $this->assertTrue($form->has('type'));
        $this->assertTrue($form->has('adresse'));
        $this->assertTrue($form->has('submit'));
    }
}
