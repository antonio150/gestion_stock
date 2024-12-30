<?php

namespace App\Controller;

use App\Repository\AchatRepository;
use App\Service\FPDFService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PDFController extends AbstractController
{
    public function generatePdf(FPDFService $fpdfService): Response
    {
        // Initialiser le PDF
        $fpdfService->AddPage();
        $fpdfService->SetFont('Arial', 'B', 16);

        // Ajouter du contenu
        $fpdfService->Cell(40, 10, 'Bonjour, voici un PDF généré avec FPDF !');

        // Générer le contenu du PDF en mémoire
        $output = $fpdfService->Output('S'); // 'S' retourne le contenu en chaîne

        // Retourner une réponse HTTP avec le PDF
        return new Response(
            $output,
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="document.pdf"',
            ]
        );
    }

    public function generateAchatPdf(AchatRepository $achatRepository, FPDFService $fpdfService): Response
    {
        // Récupérer les clients depuis la base de données
        $achats = $achatRepository->findAll();

        // Initialiser le PDF
        $fpdfService->AddPage();
        $fpdfService->getListeAchat($achats);

        // Générer le contenu du PDF
        $output = $fpdfService->Output('S');

        // Retourner une réponse HTTP avec le PDF
        return new Response(
            $output,
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="liste_clients.pdf"',
            ]
        );
    }
}
