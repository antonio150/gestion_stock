<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'app_client', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    #[Route('/ajout_client', name: 'ajout_client', methods: ['GET', 'POST'])]
    public function addClient(): Response
    {
        return $this->render('client/ajout.html.twig', []);
    }

    #[Route('/edit_client', name: 'edit_client', methods: ['POST', 'GET'])]
    public function editClient(): Response
    {
        return $this->render('client/edit.html.twig', []);
    }

    #[Route('/delete_client', name: 'delete_client', methods: ['POST'])]
    public function deleteClient(): Response
    {
        return $this->render('client/delete.html.twig', []);
    }
}
