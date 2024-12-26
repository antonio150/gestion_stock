<?php

namespace App\Controller\adminPage;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ParametreController extends AbstractController
{
    #[Route('/parametre', name: 'app_parametre')]
    public function index(): Response
    {
        return $this->render('admin_page/parametre/index.html.twig', [
            'controller_name' => 'ParametreController',
        ]);
    }
}
