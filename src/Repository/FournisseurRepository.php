<?php

namespace App\Repository;

use App\Entity\Fournisseur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Fournisseur>
 */
class FournisseurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fournisseur::class);
    }

    public function getAll(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT * FROM fournisseur';
        $stmt = $conn->prepare($sql);
        $v = $stmt->executeQuery();
        $a = $v->fetchAllAssociative();

        return $a;
    }

    public function findFournisseur($value)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT * FROM fournisseur WHERE
         fournisseur.nom like "%'.$value.'%"';
         $stmt = $conn->prepare($sql);
         $v = $stmt->executeQuery();
         $a = $v->fetchAllAssociative();

         return $a;
    }

    //    /**
    //     * @return Fournisseur[] Returns an array of Fournisseur objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Fournisseur
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
