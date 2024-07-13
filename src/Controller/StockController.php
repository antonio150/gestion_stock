<?php

namespace App\Controller;

use App\Entity\Stock;
use App\Form\StockType;
use App\Repository\StockRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StockController extends AbstractController
{
    #[Route('/stock', name: 'app_stock')]
    public function index(
        StockRepository $stockRepository
    ): Response {
        $stock = $stockRepository->findAll();
        return $this->render('stock/index.html.twig', [
            'listestock' => $stock,
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
        return $this->render('stock/ajout.html.twig', [
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
        return $this->render('stock/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
