<?php

namespace App\Repository;

use App\Entity\Stock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Stock>
 */
class StockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stock::class);
    }

    /**
     * @return array<string, mixed>|bool
     */
    public function getQuantite(int $idProduit)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT * FROM stock WHERE 
        stock.produit_id = :produitId';
        $stmt = $conn->prepare($sql);
        $v = $stmt->executeQuery(['produitId' => $idProduit]);
        $a = $v->fetchAssociative();

        return $a;
    }

    public function updateQuantite(int $idProduit, int $qteStock): void
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'UPDATE stock set 
        stock.quantite_stock = :qteStock
        WHERE stock.produit_id=:produit_id';
        $stmt = $conn->prepare($sql);
        $v = $stmt->executeQuery([
            'qteStock' => $qteStock,
            'produit_id' => $idProduit,
        ]);
    }

    /**
     * @return array<array<string, mixed>>
     */
    public function getAll(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT stock.id, stock.quantite_stock,
        produit.nom, stock.emplacement FROM stock, produit
        WHERE stock.produit_id=produit.id';
        $stmt = $conn->prepare($sql);
        $v = $stmt->executeQuery();
        $a = $v->fetchAllAssociative();

        return $a;
    }

    /**
     * @return array<array<string, mixed>>
     */
    public function findStock(string $value): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT stock.id, stock.quantite_stock,
        stock.emplacement, produit.nom
        FROM stock, produit
        WHERE stock.produit_id = produit.id
        AND produit.nom like '%".$value."%'";
        $stmt = $conn->prepare($sql);
        $v = $stmt->executeQuery();
        $a = $v->fetchAllAssociative();

        return $a;
    }

    //    /**
    //     * @return Stock[] Returns an array of Stock objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Stock
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
