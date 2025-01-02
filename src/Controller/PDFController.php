<?php

namespace App\Controller;

use App\Repository\AchatRepository;
use App\Repository\ClientRepository;
use App\Repository\CommandeRepository;
use App\Repository\FournisseurRepository;
use App\Repository\ProduitRepository;
use App\Repository\StockRepository;
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

        $headerText = "Liste de achat";
        // Passer l'en-tête dynamique au service
        $fpdfService->setDynamicHeader($headerText);

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


    public function generateCommandePdf(CommandeRepository $commandeRepository, FPDFService $fpdfService): Response
    {
        $commande = $commandeRepository->findAll();

        $headerText = "Liste de commande";
        // Passer l'en-tête dynamique au service
        $fpdfService->setDynamicHeader($headerText);

        $fpdfService->AddPage();
        $fpdfService->getListeCommande($commande);

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

    
    public function generateProduitPdf(ProduitRepository $produitRepository, FPDFService $fpdfService): Response
    {
        $produit = $produitRepository->findAll();

        $headerText = "Liste de produit";
        // Passer l'en-tête dynamique au service
        $fpdfService->setDynamicHeader($headerText);

        $fpdfService->AddPage();
        $fpdfService->getListeProduit($produit);

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

        
    public function generateFournisseurPdf(FournisseurRepository $fournisseurRepository, FPDFService $fpdfService): Response
    {
        $fournisseur = $fournisseurRepository->findAll();

        $headerText = "Liste de fournisseur";
        // Passer l'en-tête dynamique au service
        $fpdfService->setDynamicHeader($headerText);

        $fpdfService->AddPage();
        $fpdfService->getListeFournisseur($fournisseur);

        $output = $fpdfService->Output('S');
        // Retourner une réponse HTTP avec le PDF
        return new Response(
            $output,
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="liste_fournisseur.pdf"',
            ]
        );
    }


    public function generateStockPdf(
        AchatRepository $achatRepository,
        CommandeRepository $commandeRepository,
     FPDFService $fpdfService): Response
    {
        $listeSumAchat = $achatRepository->getSumAchatParProduit();
        $listeSumCommande= $commandeRepository->getSumCommandeParProduit();
        
        // Données initiales
        $achats = $listeSumAchat; // Peut être vide
        $commandes = $listeSumCommande;

        // Fusionner les IDs des achats et des commandes
        $produits = [];

        // Ajouter les produits des achats
        foreach ($achats as $achat) {
            $produits[$achat["id"]] = [
                "nom" => $achat["nom"],
                "id" => $achat["id"],
                "quantiteAchetee" => (int) $achat["sommeQuantiteAchat"],
                "quantiteCommandee" => 0
            ];
        }

        // Ajouter ou mettre à jour les produits à partir des commandes
        foreach ($commandes as $commande) {
            $id = $commande["id"];
            if (!isset($produits[$id])) {
                // Produit n'existe pas dans les achats, donc l'ajouter
                $produits[$id] = [
                    "nom" => $commande["nom"],
                    "id" => $id,
                    "quantiteAchetee" => 0, // Pas d'achat pour ce produit
                    "quantiteCommandee" => (int) $commande["sommeQuantiteCommande"]
                ];
            } else {
                // Produit existe déjà, mettre à jour la quantité commandée
                $produits[$id]["quantiteCommandee"] = (int) $commande["sommeQuantiteCommande"];
            }
        }

        // Calcul du stock disponible pour chaque produit
        $stock = [];
        foreach ($produits as $produit) {
            $stock[] = [
                "nom" => $produit["nom"],
                "id" => $produit["id"],
                "stockDisponible" => $produit["quantiteAchetee"] - $produit["quantiteCommandee"]
            ];
        }
        $headerText = "Liste de stock";
        // Passer l'en-tête dynamique au service
        $fpdfService->setDynamicHeader($headerText);

        $fpdfService->AddPage();
        $fpdfService->getListeStock($stock);
        $output = $fpdfService->Output('S');
        return new Response(
            $output,
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="liste_stock.pdf"',
            ]
        );
    }


    public function generateClientPdf(ClientRepository $clientRepository, FPDFService $fpdfService): Response
    {
        $client = $clientRepository->findAll();

        $headerText = "Liste de fournisseur";
        // Passer l'en-tête dynamique au service
        $fpdfService->setDynamicHeader($headerText);

        $fpdfService->AddPage();
        $fpdfService->getListeClient($client);

        $output = $fpdfService->Output('S');
        // Retourner une réponse HTTP avec le PDF
        return new Response(
            $output,
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="liste_client.pdf"',
            ]
        );
    }
}
