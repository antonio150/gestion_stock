<?php

namespace App\Service;

use Fpdf\Fpdf;

class FPDFService extends FPDF
{
    private $dynamicHeader = 'En-tête par défaut'; // Par défaut

    // Permet de définir l'en-tête dynamique
    public function setDynamicHeader(string $headerText): void
    {
        $this->dynamicHeader = $headerText;
    }

    public function header()
    {
        // Exemple : Ajouter un en-tête personnalisé
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, mb_convert_encoding($this->dynamicHeader, 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
    }

    public function footer()
    {
        // Exemple : Ajouter un pied de page avec numérotation
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    public function getListeAchat(array $achats)
    {
        $this->SetFont('Arial', '', 10);

        // En-têtes de colonnes
        $this->Cell(30, 10, 'Produit', 1, 0, 'C');
        $this->Cell(30, 10, 'Montant', 1, 0, 'C');
        $this->Cell(30, 10, 'Fournisseur', 1, 0, 'C');
        $this->Cell(30, 10, 'Date', 1, 0, 'C');
        $this->Cell(30, 10, 'Heure', 1, 1, 'C');

        // Contenu des colonnes
        foreach ($achats as $achat) {
            $this->Cell(30, 10, mb_convert_encoding($achat->getProduit(), 'ISO-8859-1', 'UTF-8'), 1);
            $this->Cell(30, 10, $achat->getMontant(), 1);
            $this->Cell(30, 10, mb_convert_encoding($achat->getFournisseur(), 'ISO-8859-1', 'UTF-8'), 1);

            $dateAchat = $achat->getDateAchat();
            $this->Cell(30, 10, $dateAchat instanceof \DateTime ? $dateAchat->format('d/m/Y') : '', 1);
            
            $timeAchat = $achat->getTime();
            $this->Cell(30, 10, $timeAchat instanceof \DateTime ? $timeAchat->format('H:i:s') : '', 1);
            $this->Ln();
        }
    }


    public function getListeCommande(array $commande)
    {
        $this->SetFont('Arial', '', 10);

        // En-têtes de colonnes
        $this->Cell(30, 10, 'Quantite', 1, 0, 'C');
        $this->Cell(30, 10, 'Client', 1, 0, 'C');
        $this->Cell(30, 10, 'Produit', 1, 0, 'C');
        $this->Cell(30, 10, 'Date de commande', 1, 1, 'C');
       
        // Contenu des colonnes
        foreach ($commande as $command) {
            $this->Cell(30, 10, $command->getQuantiteCommande(), 1);
            $this->Cell(30, 10, mb_convert_encoding($command->getIdClient(), 'ISO-8859-1', 'UTF-8'), 1);
            
            $this->Cell(30, 10, mb_convert_encoding($command->getProduit(), 'ISO-8859-1', 'UTF-8'), 1);

            $dateCommande = $command->getDateCommande();
            $this->Cell(30, 10, $dateCommande instanceof \DateTime ? $dateCommande->format('d/m/Y') : '', 1);
            
            $this->Ln();
        }
    }

    public function getListeProduit(array $produit)
    {
        $this->SetFont('Arial', '', 10);

        // En-têtes de colonnes
        $this->Cell(30, 10, 'Nom', 1, 0, 'C');
        $this->Cell(50, 10, 'Description', 1, 0, 'C');
        $this->Cell(30, 10, 'Prix Unitaire', 1, 0, 'C');
        $this->Cell(30, 10, 'Fournisseur', 1, 1, 'C');

        // Contenu des colonnes
        foreach ($produit as $prod) {
            $x = $this->GetX(); // Position X actuelle
            $y = $this->GetY(); // Position Y actuelle

            // Définir une largeur pour chaque colonne
            $colNom = 30;
            $colDescription = 50;
            $colPrix = 30;
            $colFournisseur = 30;

            // Hauteur initiale de la ligne
            $lineHeight = 10;

            // Description (avec MultiCell pour gérer le texte long)
            $this->SetXY($x + $colNom, $y); // Positionner la description
            $this->MultiCell($colDescription, $lineHeight, mb_convert_encoding($prod->getDescription(), 'ISO-8859-1', 'UTF-8'), 1);

            // Calculer la hauteur de la cellule Description
            $currentY = $this->GetY();
            $rowHeight = $currentY - $y; // Hauteur totale utilisée par la description

            // Ajuster les autres colonnes à la même hauteur
            $this->SetXY($x, $y); // Retourner pour Nom
            $this->Cell($colNom, $rowHeight, mb_convert_encoding($prod->getNom(), 'ISO-8859-1', 'UTF-8'), 1);

            $this->SetXY($x + $colNom + $colDescription, $y); // Retourner pour Prix Unitaire
            $this->Cell($colPrix, $rowHeight, $prod->getPrixUnit(), 1, 0, 'C');

            $this->SetXY($x + $colNom + $colDescription + $colPrix, $y); // Retourner pour Fournisseur
            $this->Cell($colFournisseur, $rowHeight, mb_convert_encoding($prod->getFournisseur(), 'ISO-8859-1', 'UTF-8'), 1);

            // Déplacer à la ligne suivante
            $this->SetY($y + $rowHeight);
        }
    }


    public function getListeFournisseur(array $fournisseur)
    {
        $this->SetFont('Arial', '', 10);

        // En-têtes de colonnes
        $this->Cell(30, 10, 'Nom', 1, 0, 'C');
        $this->Cell(50, 10, 'Type', 1, 0, 'C');
        $this->Cell(30, 10, 'Adresse', 1, 1, 'C');

        // Contenu des colonnes
        foreach ($fournisseur as $fourniss) {
            $x = $this->GetX(); // Position X actuelle
            $y = $this->GetY(); // Position Y actuelle

            // Définir une largeur pour chaque colonne
            $colNom = 30;
            $colType = 50;
            $colAdresse = 30;

            // Hauteur initiale de la ligne
            $lineHeight = 10;

            // Description (avec MultiCell pour gérer le texte long)
            $this->SetXY($x, $y); // Positionner la description
            $this->MultiCell($colNom, $lineHeight, mb_convert_encoding($fourniss->getNom(), 'ISO-8859-1', 'UTF-8'), 1);

            // Calculer la hauteur de la cellule Description
            $currentY = $this->GetY();
            $rowHeight = $currentY - $y; // Hauteur totale utilisée par la description

            // Ajuster les autres colonnes à la même hauteur
            $this->SetXY($x + $colNom, $y); // Retourner pour Nom
            $this->Cell($colType, $rowHeight, mb_convert_encoding($fourniss->getType(), 'ISO-8859-1', 'UTF-8'), 1);

            $this->SetXY($x + $colNom + $colType, $y); // Retourner pour Prix Unitaire
            $this->Cell($colAdresse, $rowHeight, $fourniss->getAdresse(), 1, 0, 'C');

            // Déplacer à la ligne suivante
            $this->SetY($y + $rowHeight);
        }
    }

    public function getListeStock(array $stock)
    {
        $this->SetFont('Arial', '', 10);

        // En-têtes de colonnes
        $this->Cell(50, 10, 'Nom', 1, 0, 'C');
        $this->Cell(50, 10, 'Quantite', 1, 1, 'C');

        // Contenu des colonnes
        foreach ($stock as $stocks) {
            $x = $this->GetX(); // Position X actuelle
            $y = $this->GetY(); // Position Y actuelle

            // Définir une largeur pour chaque colonne
            $colNom = 50;
            $colQuantite = 50;

            // Hauteur initiale de la ligne
            $lineHeight = 10;

            // Description (avec MultiCell pour gérer le texte long)
            $this->SetXY($x, $y); // Positionner la description
            $this->MultiCell($colNom, $lineHeight, mb_convert_encoding($stocks['nom'], 'ISO-8859-1', 'UTF-8'), 1);

            // Calculer la hauteur de la cellule Description
            $currentY = $this->GetY();
            $rowHeight = $currentY - $y; // Hauteur totale utilisée par la description

            // Ajuster les autres colonnes à la même hauteur
            $this->SetXY($x + $colNom, $y); // Retourner pour Nom
            $this->Cell($colQuantite, $rowHeight, mb_convert_encoding($stocks['stockDisponible'], 'ISO-8859-1', 'UTF-8'), 1);

            // Déplacer à la ligne suivante
            $this->SetY($y + $rowHeight);
        }


        
    }


    public function getListeClient(array $client)
    {
        $this->SetFont('Arial', '', 10);

        // En-têtes de colonnes
        $this->Cell(50, 10, 'Nom', 1, 0, 'C');
        $this->Cell(50, 10, mb_convert_encoding('Prénom', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
        $this->Cell(50, 10, 'Adresse', 1, 1, 'C');

        // Contenu des colonnes
        foreach ($client as $clients) {
            $x = $this->GetX(); // Position X actuelle
            $y = $this->GetY(); // Position Y actuelle

            // Définir une largeur pour chaque colonne
            $colNom = 50;
            $colPrenom = 50;
            $colAdresse = 50;

            // Hauteur initiale de la ligne
            $lineHeight = 10;

            // Description (avec MultiCell pour gérer le texte long)
            $this->SetXY($x, $y); // Positionner la description
            $this->MultiCell($colNom, $lineHeight, mb_convert_encoding($clients->getNom(), 'ISO-8859-1', 'UTF-8'), 1);

            // Calculer la hauteur de la cellule Description
            $currentY = $this->GetY();
            $rowHeight = $currentY - $y; 

            // Ajuster les autres colonnes à la même hauteur
            $this->SetXY($x + $colNom, $y); // Retourner pour Nom
            $this->MultiCell($colPrenom, $rowHeight, mb_convert_encoding($clients->getPrenom(), 'ISO-8859-1', 'UTF-8'), 1);

             // Calculer la hauteur de la cellule Description
             $currentY = $this->GetY();
             $rowHeight = $currentY - $y; 
            // Ajuster les autres colonnes à la même hauteur
            $this->SetXY($x + $colNom + $colPrenom, $y); // Retourner pour Nom
            $this->MultiCell($colAdresse, $rowHeight, mb_convert_encoding($clients->getAdresse(), 'ISO-8859-1', 'UTF-8'), 1);

            // Déplacer à la ligne suivante
            $this->SetY($y + $rowHeight);
        }


        
    }

}
