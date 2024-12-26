<?php

namespace App\Controller\clientPage;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Form\SearchProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProduitController extends AbstractController
{
    #[Route('/produit', name: 'app_produit')]
    public function index(ProduitRepository $produitRepository,
        Request $request): Response
    {
        $listeProduit = $produitRepository->getAll();
       
        $formRecherche = $this->createForm(SearchProduitType::class);
        $formRecherche->handleRequest($request);

        if ($formRecherche->isSubmitted()) {
            $data = $formRecherche->getData();
            $route = [
                'nomProduit' => $data['produit'],
            ];

            return $this->redirectToRoute('app_produit', $route);
        }

        if (isset($_GET['nomProduit'])) {
            $listeProduit = $produitRepository->findNom($_GET['nomProduit']);
        }

        //  dd($listeProduit);
        return $this->render('client_page/produit/index.html.twig', [
            'listeProduit' => $listeProduit,
           
            'form' => $formRecherche,
        ]);
    }

    #[Route('/ajout_produit', name: 'ajout_produit', methods: ['GET', 'POST'])]
    public function addProduit(
        Request $request,
        EntityManagerInterface $entityManagerInterface,
    ): Response {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManagerInterface->persist($produit);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_produit');
        }

        return $this->render('client_page/produit/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/edit_produit/{id}', name: 'edit_produit', methods: ['GET', 'POST'])]
    public function editProduit(
        Produit $produit,
        EntityManagerInterface $entityManagerInterface,
        Request $request
    ): Response {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManagerInterface->persist($produit);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_produit');
        }

        return $this->render('client_page/produit/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('produit/delete/{id}', name: 'delete_produit')]
    public function deleteProduit(
        Produit $produit,
        EntityManagerInterface $entityManagerInterface
    ): Response {
        $entityManagerInterface->remove($produit);
        $entityManagerInterface->flush();

        return $this->redirectToRoute('app_produit');
    }
}
