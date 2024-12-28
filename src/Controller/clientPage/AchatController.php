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

        $mouvement = new Mouvement();

        $listProduit = $produitRepository->findAll();
        $listFournisseur = $fournisseurRepository->findAll();
        if($request->isMethod('POST'))
        {

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

    #[Route('/achat/modification/{id}', name: 'edit_achat', methods:['GET', 'POST'])]
    public function edit(
        Achat $achat,
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        ValidatorInterface $validatorInterface,
        AchatRepository $achatRepository,
        ProduitRepository $produitRepository,
        FournisseurRepository $fournisseurRepository
    ):Response
    {
        $route = [
            'id' => $achat->getId()
        ];

        $id = $route['id'];
        $achatValue = $achatRepository->findById($id);

        $listProduit = $produitRepository->findAll();
        $listFournisseur = $fournisseurRepository->findAll();
        dd($achatValue['produit']);

        return $this->render('client_page/achat/edit.html.twig', [
            'achatValue' => $achatValue,
            'listProduit' => $listProduit,
            'listFournisseur' => $listFournisseur,
        ]);
    }
}
