<?php

namespace App\Controller\clientPage;

use App\Entity\Achat;
use App\Form\AchatType;
use App\Form\ClientType;
use App\Repository\AchatRepository;
use App\Repository\FournisseurRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AchatController extends AbstractController
{
    #[Route('/achat', name: 'app_achat')]
    public function index(
        AchatRepository $achatRepository
    ): Response
    {
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
    ):Response
    {
        $achat = new Achat();
        $form = $this->createForm(AchatType::class, $achat);
        $data = $request->request->all();

        $listProduit = $produitRepository->findAll();
        $listFournisseur = $fournisseurRepository->findAll();
        if($request->isMethod('POST'))
        {

            $prod = $produitRepository->find($data['produit']);
            $fourniss = $fournisseurRepository->find($data['fournisseur']);
            $dateAchat = new \DateTime($data['date_achat']);
            $timeAchat = new \DateTime($data['time_achat']);
            $achat->setProduit($prod);
            $achat->setMontant($data['montant']);
            $achat->setFournisseur($fourniss);
            $achat->setDateAchat($dateAchat);
            $achat->setTime($timeAchat);
           
            $entityManagerInterface->persist($achat);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_achat');
        }
        
       

        return $this->render('client_page/achat/ajout.html.twig', [
            'form' => $form->createView(),
            'listProduit' => $listProduit,
            'listFournisseur' => $listFournisseur,
        ]);

    }
}
