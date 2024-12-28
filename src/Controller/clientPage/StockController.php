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
        // echo "<pre>";
        // var_dump($listeSumAchat);
        // var_dump($listeSumCommande);
        // echo "</pre>";


        $listeStock = [];
        $quantiteAchat = 0;
        foreach ($listeSumAchat as $listAchat)
        {
            $quantiteAchetee = (int) $listAchat["sommeQuantiteAchat"];
            $quantiteCommande = 0;
            foreach($listeSumCommande as $listCommande)
            {
                if($listAchat['id'] == $listCommande['id'])
                {
                    $quantiteCommande = $listCommande['sommeQuantiteCommande'];
                  break;
                }
            }

            $stock =  $quantiteAchetee - $quantiteCommande ;
                  
            $arrayStock = [$listAchat['nom'], $stock];
            array_push($listeStock, $arrayStock);
        }

      

        return $this->render('client_page/stock/index.html.twig', [
            "listeStock" => $listeStock
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
