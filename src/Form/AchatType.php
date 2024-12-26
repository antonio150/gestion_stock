<?php

namespace App\Form;

use App\Entity\Achat;
use App\Entity\fournisseur;
use App\Entity\produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AchatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant')
            ->add('date_achat', null, [
                'widget' => 'single_text'
            ])
            ->add('time', null, [
                'widget' => 'single_text'
            ])
            ->add('produit', EntityType::class, [
                'class' => Produit::class,
'choice_label' => 'nom',
            ])
            ->add('fournisseur', EntityType::class, [
                'class' => Fournisseur::class,
'choice_label' => 'nom',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Achat::class,
        ]);
    }
}
