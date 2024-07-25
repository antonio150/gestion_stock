<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Stock;
use App\Form\CommandeType;
use App\Form\SearchCommandeFormType;
use App\Repository\CommandeRepository;
use App\Repository\StockRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande', methods: ['GET', 'POST'])]
    public function index(
        CommandeRepository $commandeRepository,
        Request $request
    ): Response {


        $formRecherche = $this->createForm(SearchCommandeFormType::class);
        $formRecherche->handleRequest($request);
       
        $commande = $commandeRepository->findAllCommande();
        if ($formRecherche->isSubmitted()) {
            $data = $formRecherche->getData();
            //  dd($data["produit"]);
            $route = [
                'nomProduit' => $data["produit"],
            ];
            
            return $this->redirectToRoute('app_commande', $route);
        }

        if(isset($_GET['nomProduit']))
        {
            $commande = $commandeRepository->findProduitInStock($_GET['nomProduit']);
        }
        $req = require("../templates/navbar/menu.html.twig");

        return $this->render('commande/index.html.twig', [
            'commande' => $commande,
            'require' => $req,
            'form' => $formRecherche,
        ]);
    }

    #[Route('/ajout_commande', name: 'ajout_commande', methods: ['GET', 'POST'])]
    public function addCommande(
        Request $request,
        EntityManagerInterface $entityManagerInterface,

        StockRepository $stockRepository,
    ) {
        $commande = new Commande();
        $stock = new Stock();
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManagerInterface->persist($commande);
            $entityManagerInterface->flush();

            $qteCommandeProduit = $commande->getQuantiteCommande();
            $produit = $commande->getProduit();
            $idProduit = $produit->getId();
            $stock = $stockRepository->getQuantite($idProduit);

            $qteStock = intval($stock['quantite_stock']);
            $qteCommandProd = intval($qteCommandeProduit);
            $qte = $qteStock - $qteCommandProd;

            $stockRepository->updateQuantite($idProduit, $qte);

            return $this->redirectToRoute('app_commande');
        }



        return $this->render('commande/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(
        'commande_edit/{id}',
        name: 'edit_commande',
        methods: ['GET', 'POST']
    )]
    public function editCommande(
        Commande $commande,
        Request $request,
        StockRepository $stockRepository,
        EntityManagerInterface $entityManagerInterface
    ): Response {
        $qteCommandeAvant = $commande->getQuantiteCommande();
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form->getData();

            $qteCommandeApres = $commande->getQuantiteCommande();
            $qteCommandeApres = intval($qteCommandeApres);
            $qteCommandeAvant = intval($qteCommandeAvant);
            $qteCommandeVerification = $qteCommandeApres - $qteCommandeAvant;
            $produit = $commande->getProduit();
            $idProduit = $produit->getId();
            $stockQte = $stockRepository->getQuantite($idProduit);
            $stockQte = intval($stockQte['quantite_stock']);
            // dump($qteCommandeAvant);
            // dd($qteCommandeVerification);
            // dump($qteCommandeApres);
            // dd($stockQte);
            if ($qteCommandeVerification > 0) {
                $qte =  $stockQte - $qteCommandeVerification;

                $stockRepository->updateQuantite($idProduit, $qte);
            } else if ($qteCommandeVerification < 0) {
                $qte = $stockQte - $qteCommandeVerification;

                $stockRepository->updateQuantite($idProduit, $qte);
            }
            $entityManagerInterface->persist($commande);
            $entityManagerInterface->flush();



            return $this->redirectToRoute('app_commande');
        }

        return $this->render(
            'commande/edit.html.twig',
            ['form' => $form->createView()]
        );
    }

    #[Route(
        '/delete_commande/{id}',
        name: 'delete_commande',
        methods: ['GET', 'POST']
    )]
    public function deleteCommande(
        Commande $commande,
        EntityManagerInterface $entityManagerInterface,
        StockRepository $stockRepository
    ) {
        $quantiteCommandeProduit = $commande->getQuantiteCommande();
        $produit = $commande->getProduit();
        $idProduit = $produit->getId();
        $stock = $stockRepository->getQuantite($idProduit);
        // dd($stock);
        if ($stock) {
            $entityManagerInterface->remove($commande);
            $entityManagerInterface->flush();

            $qteStock = intval($stock['quantite_stock']);
            $qteCommandProd = intval($quantiteCommandeProduit);
            $qte = $qteStock + $qteCommandProd;

            $stockRepository->updateQuantite($idProduit, $qte);
        } else {
            $errorMessage = "Produit n'existe pas dans stock";
            $this->addFlash('error', $errorMessage);
        }

        return $this->redirectToRoute('app_commande');
    }
}
