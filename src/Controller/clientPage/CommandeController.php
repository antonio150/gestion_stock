<?php

namespace App\Controller\clientPage;

use App\Entity\Commande;
use App\Entity\Mouvement;
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
                'nomProduit' => $data['produit'],
            ];

            return $this->redirectToRoute('app_commande', $route);
        }

        if (isset($_GET['nomProduit'])) {
            $commande = $commandeRepository->findProduitInStock($_GET['nomProduit']);
        }
        
        return $this->render('client_page/commande/index.html.twig', [
            'commande' => $commande,
          
            'form' => $formRecherche,
        ]);
    }

    #[Route('/ajout_commande', name: 'ajout_commande', methods: ['GET', 'POST'])]
    public function addCommande(
        Request $request,
        EntityManagerInterface $entityManagerInterface,

        StockRepository $stockRepository,
    ): Response {
        $commande = new Commande();
        $stock = new Stock();
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        $mouvement = new Mouvement();
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManagerInterface->persist($commande);
            $entityManagerInterface->flush();

            $produit = $form->get('Produit')->getData();
            $quantite = $form->get('quantiteCommande')->getData();
            $date_commande = $form->get('date_commande')->getData();



            $mouvement->setProduit($produit);
            $mouvement->setType('sortie');
            $mouvement->setQuantite($quantite);
            $mouvement->setDate($date_commande);

            $entityManagerInterface->persist($mouvement);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_commande');
        }

        return $this->render('client_page/commande/ajout.html.twig', [
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
           

            $entityManagerInterface->persist($commande);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_commande');
        }

        return $this->render(
            'client_page/commande/edit.html.twig',
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
    ): Response {
        $entityManagerInterface->remove($commande);
        $entityManagerInterface->flush();
        return $this->redirectToRoute('app_commande');
    }
}
