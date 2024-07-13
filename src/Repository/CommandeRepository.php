<?php

namespace App\Repository;

use App\Entity\Commande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Commande>
 */
class CommandeRepository extends ServiceEntityRepository
{
    private $connection;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commande::class);
    }

    public function getAllProduitInCommandeById($produitId)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT * FROM commande WHERE commande.produit_id = :produitId';
        $stmt = $conn->prepare($sql);
        $v = $stmt->executeQuery(['produitId' => $produitId]);
        $a = $v->fetchAllAssociative();

        return $a;
    }

    public function findCommandeDistincte()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT SUM(commande.quantite_commande) as SumQte ,
        commande.id_client_id, commande.id,client.nom as nomCLient,
        commande.produit_id, produit.nom as nomProduit FROM commande, produit , client
        WHERE commande.produit_id=produit.id 
        and commande.id_client_id = client.id
        GROUP BY produit_id';
        $stmt = $conn->prepare($sql);
        $v = $stmt->executeQuery();
        $a = $v->fetchAllAssociative();

        return $a;
    }

    //    /**
    //     * @return Commande[] Returns an array of Commande objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Commande
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
