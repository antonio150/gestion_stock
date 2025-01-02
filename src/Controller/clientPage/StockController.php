<?php

namespace App\Controller\clientPage;

use App\Entity\Stock;
use App\Form\SearchStockType;
use App\Form\StockType;
use App\Repository\AchatRepository;
use App\Repository\CommandeRepository;
use App\Repository\StockRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StockController extends AbstractController
{
    #[Route('/', name: 'app_stock')]
    public function index(
        AchatRepository $achatRepository,
        CommandeRepository $commandeRepository,
        Request $request
    ): Response {
       
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


      

        return $this->render('client_page/stock/index.html.twig', [
            "listeStock" => $stock
        ]);
    }

        #[Route('/ajout_stock', name: 'ajout_stock', methods: ['GET', 'POST'])]
        public function addStock(
            Request $request,
            EntityManagerInterface $entityManagerInterface
        ): Response {
            $stock = new Stock();
            $form = $this->createForm(StockType::class, $stock);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManagerInterface->persist($stock);
                $entityManagerInterface->flush();

                return $this->redirectToRoute('app_stock');
            }

            return $this->render('client_page/stock/ajout.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        #[Route('/edit_stock/{id}', name: 'edit_stock', methods: ['GET', 'POST'])]
        public function editStock(
            Stock $stock,
            Request $request,
            EntityManagerInterface $entityManagerInterface
        ): Response {
            $form = $this->createForm(StockType::class, $stock);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManagerInterface->persist($stock);
                $entityManagerInterface->flush();

                return $this->redirectToRoute('app_stock');
            }

            return $this->render('client_page/stock/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        }
}
