<?php

namespace App\Controller\adminPage;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TableboardController extends AbstractController
{
    #[Route('/tableboard', name: 'app_tableboard')]
    public function index(): Response
    {
        return $this->render('admin_page/tableboard/index.html.twig', [
            'controller_name' => 'TableboardController',
        ]);
    }
}
