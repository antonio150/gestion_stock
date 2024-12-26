<?php

namespace App\Form;

use App\Entity\Fournisseur;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => true,
            ])
            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('prixUnit', NumberType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => true,
            ])
            ->add('fournisseur', EntityType::class, [
                'class' => Fournisseur::class,
                'choice_label' => 'nom',
                'required' => true,
                'attr' => [
                    'required' => 'required', // Forcer l'attribut HTML
                ],
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
