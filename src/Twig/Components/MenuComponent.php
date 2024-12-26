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
        if ($this->security->isGranted('ROLE_ADMIN')) {
            $this->items = [
                ['label' => 'client', 'route' => 'app_client'],
                ['label' => 'Stock', 'route' => 'app_stock'],
                ['label' => 'Fournisseur', 'route' => 'app_fournisseur'],
                ['label' => 'Produit', 'route' => 'app_produit'],
                ['label' => 'Commande', 'route' => 'app_commande'],
                ['label' => 'Achat', 'route' => 'app_achat'],
                ['label' => 'Tableau de bord', 'route' => 'dashboard'],
                ['label' => 'Deconnecter', 'route' => 'app_logout'],
            ];
        } else {
            $this->items = [
                ['label' => 'client', 'route' => 'app_client'],
                ['label' => 'Stock', 'route' => 'app_stock'],
                ['label' => 'Fournisseur', 'route' => 'app_fournisseur'],
                ['label' => 'Produit', 'route' => 'app_produit'],
                ['label' => 'Commande', 'route' => 'app_commande'],
                ['label' => 'Achat', 'route' => 'app_achat'],
                ['label' => 'Deconnecter', 'route' => 'app_logout'],
            ];
        }
    }
}
