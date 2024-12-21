<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ErrorController extends AbstractController
{
    public function show(\Throwable $exception): Response
    {
        // Vérifiez si l'exception est une exception HTTP
        $statusCode = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : 500;

        // Personnalisez la page d'erreur pour le code 403
        if ($statusCode === 403) {
            return $this->render('error/403.html.twig', [
                'message' => $exception->getMessage(),
            ]);
        }

        // Utilisez des pages génériques pour d'autres erreurs
        return $this->render('error/error.html.twig', [
            'status_code' => $statusCode,
            'message' => $exception->getMessage(),
        ]);
    }
}
