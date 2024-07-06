<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
use App\Repository\FournisseurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande')]
    public function index(
        CommandeRepository $commandeRepository
    ): Response
    {
        $commande = $commandeRepository->findAll();

        return $this->render('commande/index.html.twig', [
            'commande' => $commande,
        ]);
    }
}
