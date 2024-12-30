<?php

namespace App\Controller\clientPage;

use App\Entity\Achat;
use App\Entity\Mouvement;
use App\Entity\Produit;
use App\Form\AchatType;
use App\Form\ClientType;
use App\Repository\AchatRepository;
use App\Repository\FournisseurRepository;
use App\Repository\ProduitRepository;
use App\Service\FPDFService;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Builder\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AchatController extends AbstractController
{
    #[Route('/achat', name: 'app_achat')]
    public function index(
        AchatRepository $achatRepository
    ): Response {
        $listAchat = $achatRepository->findAll();

        return $this->render('client_page/achat/index.html.twig', [
            'listeAchat' => $listAchat
        ]);
    }

    #[Route('/achat/ajout', name: 'ajout_achat')]
    public function ajout(
        EntityManagerInterface $entityManagerInterface,
        Request $request,
        ProduitRepository $produitRepository,
        FournisseurRepository $fournisseurRepository
    ): Response {
        $achat = new Achat();
        $form = $this->createForm(AchatType::class, $achat);
        $data = $request->request->all();

        $mouvement = new Mouvement();

        $listProduit = $produitRepository->findAll();
        $listFournisseur = $fournisseurRepository->findAll();
        if ($request->isMethod('POST')) {

            // $prod = $produitRepository->find($data['produit']);
            $prod = $entityManagerInterface->getRepository(Produit::class)->find($data['produit']);
            $fourniss = $fournisseurRepository->find($data['fournisseur']);
            $dateAchat = new \DateTime($data['date_achat']);
            $timeAchat = new \DateTime($data['time_achat']);

            // dd($prod->getNom());
            $achat->setProduit($prod);
            $achat->setMontant($data['montant']);
            $achat->setFournisseur($fourniss);
            $achat->setDateAchat($dateAchat);
            $achat->setTime($timeAchat);
            $achat->setQuantite($data['quantite']);

            $mouvement->setProduit($prod);
            $mouvement->setType('entree');
            $mouvement->setQuantite($data['quantite']);
            $mouvement->setDate($dateAchat);

            $entityManagerInterface->persist($achat);
            $entityManagerInterface->flush();

            $entityManagerInterface->persist($mouvement);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_achat');
        }



        return $this->render('client_page/achat/ajout.html.twig', [
            'form' => $form->createView(),
            'listProduit' => $listProduit,
            'listFournisseur' => $listFournisseur,
        ]);
    }

    #[Route('/achat/modification/{id}', name: 'edit_achat', methods: ['GET', 'POST'])]
    public function edit(
        Achat $achat,
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        ValidatorInterface $validatorInterface,
        AchatRepository $achatRepository,
        ProduitRepository $produitRepository,
        FournisseurRepository $fournisseurRepository
    ): Response {
        $route = [
            'id' => $achat->getId()
        ];


        $id = $route['id'];
        $achatValue = $achatRepository->findById($id);

        $listProduit = $produitRepository->findAll();
        $listFournisseur = $fournisseurRepository->findAll();
        // dd($achatValue);
        if ($request->isMethod('POST')) {

            $data = $request->request->all();

            $produit = $data['produit'];
            $produit = $produitRepository->find($produit);
            $montant = $data['montant'];
            $fournisseur = $data['fournisseur'];
            $fournisseur = $fournisseurRepository->find($fournisseur);
            $quantite = $data['quantite'];
            $date_achat = $data['date_achat'];
            $date_achat = new \DateTime($date_achat);
            $time_achat = $data['time_achat'];
            $time_achat = new \DateTime($time_achat);

            $achat->setProduit($produit);
            $achat->setMontant($montant);
            $achat->setFournisseur($fournisseur);
            $achat->setQuantite($quantite);
            $achat->setDateAchat($date_achat);
            $achat->setTime($time_achat);

            $entityManagerInterface->persist($achat);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_achat');
        }

        return $this->render('client_page/achat/edit.html.twig', [
            'achatValue' => $achatValue,
            'listProduit' => $listProduit,
            'listFournisseur' => $listFournisseur,
            'idAchat' => $route['id']
        ]);
    }

    #[Route('/achat/export', name: 'pdf_generate', methods: ['GET', 'POST'])]
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

    #[Route('achat/delete/{id}', name: 'delete_achat')]
    public function supprimerAchat(
        Achat $achat,
        EntityManagerInterface $entityManagerInterface
    )
    {
        $entityManagerInterface->remove($achat);
        $entityManagerInterface->flush();
        return $this->redirectToRoute('app_achat');

    }
}
