<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Produit>
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    public function getAll()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT produit.id, produit.nom,
         produit.description, produit.prix_unit,
        fournisseur.nom as nomFournisseur
         FROM produit, fournisseur
         WHERE produit.fournisseur_id = fournisseur.id ';
        $stmt = $conn->prepare($sql);
        $v = $stmt->executeQuery();
        $a = $v->fetchAllAssociative();

        return $a;
    }


    public function findNom($produit)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT produit.id, produit.nom,
        produit.description, produit.prix_unit,
        fournisseur.nom as nomFournisseur FROM produit, fournisseur WHERE 
        produit.fournisseur_id = fournisseur.id and
        produit.nom like "%'.$produit.'%"';
        $stmt = $conn->prepare($sql);
        $v = $stmt->executeQuery();
        $a = $v->fetchAllAssociative();

        return $a;
    }


    //    /**
    //     * @return Produit[] Returns an array of Produit objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Produit
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
