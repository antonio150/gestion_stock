<?php

namespace App\Controller\clientPage;

use App\Entity\Client;
use App\Form\ClientType;
use App\Form\SearchClientType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'app_client', methods: ['GET', 'POST'])]
    public function index(Request $request, ClientRepository $clientRepository): Response
    {
        $client = new Client();
        $listeClient = $clientRepository->getAll();
        $formRecherche = $this->createForm(SearchClientType::class);
        $formRecherche->handleRequest($request);

        if ($formRecherche->isSubmitted()) {
            $data = $formRecherche->getData();
            $route = [
                'value' => $data['client'],
            ];

            return $this->redirectToRoute('app_client', $route);
        }

        if (isset($_GET['value'])) {
            $listeClient = $clientRepository->findClient($_GET['value']);
        }

        // $req = require '../templates/navbar/menu.html.twig';

        return $this->render('client_page/client/index.html.twig', [
            'listeClient' => $listeClient,
            'form' => $formRecherche,
            // 'require' => $req,
        ]);
    }

        #[Route('/ajout_client', name: 'ajout_client', methods: ['GET', 'POST'])]
        public function addClient(
            Request $request,
            EntityManagerInterface $entityManagerInterface,
            ValidatorInterface $validatorInterface
        ): Response {
            $client = new Client();
            $form = $this->createForm(ClientType::class, $client);

            $this->denyAccessUnlessGranted('VIEW', $client);
            $errorMessages = [];
            $form->handleRequest($request);
            $errors = null;
            if ($form->isSubmitted()) {
                if ($form->isValid()) {
                    $entityManagerInterface->persist($client);
                    $entityManagerInterface->flush();

                    return $this->redirectToRoute('app_client');
                } else {
                    $errors = $validatorInterface->validate($client);
                    foreach ($errors as $error) {
                        $this->addFlash('error', $error->getMessage());
                    }

                    return $this->redirectToRoute('ajout_client');
                }
            }

            return $this->render('client_page/client/ajout.html.twig', [
                'form' => $form->createView(),
                'errors' => $errors,
            ]);
        }

        #[Route('/edit_client/{id}', name: 'edit_client', methods: ['POST', 'GET'])]
        public function editClient(
            Client $client,
            Request $request,
            EntityManagerInterface $entityManagerInterface,
            ValidatorInterface $validatorInterface
        ): Response {
            $form = $this->createForm(ClientType::class, $client);
            $form->handleRequest($request);
            $route = [
                'id' => $client->getId(),
            ];
            if ($form->isSubmitted()) {
                if ($form->isValid()) {
                    $form->getData();
                    $entityManagerInterface->persist($client);
                    $entityManagerInterface->flush();

                    return $this->redirectToRoute('app_client');
                } else {
                    $errors = $validatorInterface->validate($client);
                    foreach ($errors as $error) {
                        $this->addFlash('error', $error->getMessage());
                    }

                    return $this->redirectToRoute('edit_client', $route);
                }
            }

            return $this->render('client_page/client/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        #[Route('/delete_client/{id}', name: 'delete_client', methods: ['POST', 'GET'])]
        public function deleteClient(Client $client, EntityManagerInterface $manager): Response
        {
            $manager->remove($client);
            $manager->flush();

            return $this->redirectToRoute('app_client');
        }
}
