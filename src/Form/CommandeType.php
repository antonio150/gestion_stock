<?php

namespace App\Form;

use App\Entity\client;
use App\Entity\Commande;
use App\Entity\produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantiteCommande')
            ->add('idClient', EntityType::class, [
                'class' => client::class,
                'choice_label' => 'id',
            ])
            ->add('Produit', EntityType::class, [
                'class' => produit::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
