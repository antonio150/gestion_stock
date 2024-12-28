<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantiteCommande', IntegerType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => true,
                'label'=> 'Quantite commande'
            ])
            ->add('idClient', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'nom',
                'required' => true,
                'label'=> 'Nom client',
                'placeholder' => 'Sélectionnez un client', // Ajoute une option vide
            ])
            ->add('Produit', EntityType::class, [
                'class' => Produit::class,
                'choice_label' => 'nom',
                'required' => true,
                'label'=> 'Nom produit',
                'placeholder' => 'Sélectionnez un produit',
            ])
            ->add('date_commande', DateType::class,[
                'label' => 'Date de commande',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
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
