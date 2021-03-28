<?php

namespace App\Repository;

use App\Entity\StockUploadTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StockUploadTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method StockUploadTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method StockUploadTable[]    findAll()
 * @method StockUploadTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockUploadTableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StockUploadTable::class);
    }

    // /**
    //  * @return StockUploadTable[] Returns an array of StockUploadTable objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StockUploadTable
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
