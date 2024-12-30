<?php

namespace App\Service;

use Fpdf\Fpdf;

class FPDFService extends FPDF
{
    public function header()
    {
        // Exemple : Ajouter un en-tête personnalisé
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, mb_convert_encoding('Mon En-tête', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
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
}
