<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(): Response
    {
        // $req = require '../templates/dashboard/menu_dashboard.html.twig';
        $menuItems = [
            ['label' => 'Tableau de bord', 'url' => '/tableboard'],
            ['label' => 'Utilisateur', 'url' => '/utilisateur'],
            ['label' => 'Parametre', 'url' => '/parametre'],
        ];
        
        return $this->render('admin_page/dashboard/index.html.twig', [
            'menuItems' => $menuItems,
        ]);
    }
}
