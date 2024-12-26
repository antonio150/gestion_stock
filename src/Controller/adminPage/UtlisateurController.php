<?php

namespace App\Controller\adminPage;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UtlisateurController extends AbstractController
{
    #[Route('/utilisateur', name: 'app_utlisateur')]
    public function index(Request $request, 
    UserRepository $userRepository): Response
    {
        $listeUser = $userRepository->findAll();

        return $this->render('admin_page/utlisateur/index.html.twig', [
            'listeUser' => $listeUser,
        ]);
    }

    #[Route('/utilisateur/ajout', name: 'ajout_user', methods:['GET','POST'])]
    public function addUser(
        Request $request, 
        EntityManagerInterface $entityManagerInterface,
        UserPasswordHasherInterface $passwordHasher,
    ):Response
    {
       
        if($request->isMethod('POST'))
        {
            $data = $request->request->all();

            $username = $data['username'];
            $password = $data['password'];
            // $roles = $data['roles'];

            // Validation manuelle (exemple simple)
            $errors = [];
            if (empty($username)) {
                $errors[] = "Le nom est requis.";
            }
            if (empty($username)) {
                $errors[] = "Un email valide est requis.";
            }
           
            // S'il n'y a pas d'erreurs, enregistrer dans la base de données
            if (empty($errors)) {
                $user = new User();
                $user->setUsername($username);
                // $user->setRoles($roles);
                // Hachage du mot de passe
                $hashedPassword = $passwordHasher->hashPassword($user, $password);
                $user->setPassword($hashedPassword);

                $allowedRoles = ['ROLE_USER', 'ROLE_ADMIN', 'ROLE_SUPER_ADMIN'];
                $roles = array_filter($data['roles'], function ($role) use ($allowedRoles) {
                    return in_array($role, $allowedRoles, true);
                });
                // Ajout des rôles
               

                
                $user->setRoles($roles);

                $entityManagerInterface->persist($user);
                $entityManagerInterface->flush();

                $this->addFlash('success', 'Utilisateur enregistré avec succès.');

                return $this->redirectToRoute('ajout_user');
            }

            // Passer les erreurs à la vue
            return $this->render('admin_page/utlisateur/ajout.html.twig', [
                'errors' => $errors,
                'username' => $username,
                'password' => $password,
            ]);
        }

        return $this->render('admin_page/utlisateur/ajout.html.twig');
    }
}
