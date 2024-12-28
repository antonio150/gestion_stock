<?php

namespace App\Controller\clientPage;

use App\Repository\MouvementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MouvementController extends AbstractController
{
    #[Route('/mouvement', name: 'app_mouvement')]
    public function index(MouvementRepository $mouvementRepository): Response
    {
        $listeMouvement = $mouvementRepository->findAll();

        return $this->render('client_page/mouvement/index.html.twig', [
            'listeMouvement' => $listeMouvement,
        ]);
    }
}
