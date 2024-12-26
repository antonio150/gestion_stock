<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('menu_dashboard', template: 'components/MenuDashboard.html.twig')]
class MenuDashboardComponent
{
    public array $menuItems = [];
}