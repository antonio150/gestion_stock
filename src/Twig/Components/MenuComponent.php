<?php

namespace App\Twig\Components;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('menu')]
class MenuComponent
{
    public array $items = [];
    public string $activeRoute = '';

    public function __construct(private Security $security)
    {
        // Dynamique selon le rôle de l'utilisateur
        // if ($this->security->isGranted('ROLE_ADMIN')) {
        //     $this->items = [
        //         ['label' => 'client', 'route' => 'app_client'],
        //         ['label' => 'Stock', 'route' => 'app_stock'],
        //         ['label' => 'Fournisseur', 'route' => 'app_fournisseur'],
        //         ['label' => 'Produit', 'route' => 'app_produit'],
        //         ['label' => 'Commande', 'route' => 'app_commande'],
        //         ['label' => 'Achat', 'route' => 'app_achat'],
        //         ['label' => 'Mouvement', 'route' => 'app_mouvement'],
        //         // ['label' => 'Tableau de bord', 'route' => 'dashboard'],
        //         ['label' => 'Deconnecter', 'route' => 'app_logout'],
        //     ];
        // } else {
            $this->items = [
                ['label' => 'client', 'route' => 'app_client', 'icon' => 'fas fa-user'],
                ['label' => 'Stock', 'route' => 'app_stock', 'icon' => 'fas fa-box'],
                ['label' => 'Fournisseur', 'route' => 'app_fournisseur', 'icon' => 'fas fa-truck'],
                ['label' => 'Produit', 'route' => 'app_produit', 'icon' => 'fas fa-cube'],
                ['label' => 'Commande', 'route' => 'app_commande', 'icon' => 'fas fa-shopping-cart'],
                ['label' => 'Achat', 'route' => 'app_achat', 'icon' => 'fas fa-shopping-bag'],
                ['label' => 'Mouvement', 'route' => 'app_mouvement', 'icon' => 'fas fa-exchange-alt'],
                ['label' => 'Deconnecter', 'route' => 'app_logout', 'icon' => 'fas fa-sign-out-alt'],
            ];
        // }
    }
}
