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

    public function getQuantite($idProduit)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT * FROM stock WHERE 
        stock.produit_id = :produitId';
        $stmt = $conn->prepare($sql);
        $v = $stmt->executeQuery(['produitId' => $idProduit]);
        $a = $v->fetchAssociative();

        return $a;
    }

    public function updateQuantite($idProduit, $qteStock)
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
