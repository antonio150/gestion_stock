<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

   

    #[ORM\Column]
    private ?int $quantiteCommande = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?client $idClient = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?produit $Produit = null;

  

   
    public function getId(): ?int
    {
        return $this->id;
    }

  

    public function getQuantiteCommande(): ?int
    {
        return $this->quantiteCommande;
    }

    public function setQuantiteCommande(int $quantiteCommande): static
    {
        $this->quantiteCommande = $quantiteCommande;

        return $this;
    }

    public function getIdClient(): ?client
    {
        return $this->idClient;
    }

    public function setIdClient(?client $idClient): static
    {
        $this->idClient = $idClient;

        return $this;
    }

    public function getProduit(): ?produit
    {
        return $this->Produit;
    }

    public function setProduit(?produit $Produit): static
    {
        $this->Produit = $Produit;

        return $this;
    }

   
}
