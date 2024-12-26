<?php

namespace App\Controller\clientPage;

use App\Entity\Fournisseur;
use App\Form\FournisseurType;
use App\Form\SearchFournisseurType;
use App\Repository\FournisseurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FournisseurController extends AbstractController
{
    #[Route('/fournisseur', name: 'app_fournisseur')]
    public function index(
        FournisseurRepository $fournisseurRepository,
        Request $request
    ): Response {
        $fournisseur = $fournisseurRepository->getAll();
        $formRecherche = $this->createForm(SearchFournisseurType::class);
        $formRecherche->handleRequest($request);

        if ($formRecherche->isSubmitted()) {
            $data = $formRecherche->getData();
            $route = [
                'value' => $data['fournisseur'],
            ];

            return $this->redirectToRoute('app_fournisseur', $route);
        }

        if (isset($_GET['value'])) {
            $fournisseur = $fournisseurRepository->findFournisseur($_GET['value']);
        }

        return $this->render('client_page/fournisseur/index.html.twig', [
            'form' => $formRecherche,
            'fournisseur' => $fournisseur,
        ]);
    }

    #[Route('/fournisseur/ajout', name: 'ajout_fournisseur', methods: ['GET', 'POST'])]
    public function addFournisseur(
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        ValidatorInterface $validatorInterface
    ): Response {
        $fournisseur = new Fournisseur();
        $form = $this->createForm(FournisseurType::class, $fournisseur);
        $form->handleRequest($request);
        $errors = null;
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManagerInterface->persist($fournisseur);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_fournisseur');
        }

        return $this->render('client_page/fournisseur/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/fournisseur/edit/{id}', name: 'edit_fournisseur')]
    public function editFournisseur(
        Fournisseur $fournisseur,
        Request $request,
        EntityManagerInterface $entityManagerInterface
    ): Response {
        $form = $this->createForm(FournisseurType::class, $fournisseur);
        $form->handleRequest($request);
        $route = [
            'id' => $fournisseur->getId(),
        ];
        if ($form->isSubmitted() && $form->isValid()) {
            $form->getData();
            $entityManagerInterface->persist($fournisseur);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_fournisseur');
        }

        return $this->render('client_page/fournisseur/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('fournisseur/delete/{id}', name: 'delete_fournisseur')]
    public function deleteFournisseur(
        Fournisseur $fournisseur,
        EntityManagerInterface $entityManagerInterface
    ): Response {
        $entityManagerInterface->remove($fournisseur);
        $entityManagerInterface->flush();

        return $this->redirectToRoute('app_fournisseur');
    }
}
