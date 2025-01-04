<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;


final class FournisseurVoter extends Voter{
    public const EDIT = 'EDIT';
    public const VIEW = 'VIEW';

   

    protected function supports(string $attribute, mixed $subject): bool
    {
       
        return in_array($attribute, [self::EDIT, self::VIEW])
            && $subject instanceof \App\Entity\Fournisseur;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
       
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
       
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                // logic to determine if the user can EDIT
                // Seul l'auteur de l'article peut éditer
                return in_array('ROLE_ADMIN', $user->getRoles());
               
            case self::VIEW:
                // logic to determine if the user can VIEW
                return in_array('ROLE_USER', $user->getRoles());;
        }

        return false;
    }
}
