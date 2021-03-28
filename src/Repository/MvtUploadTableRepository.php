<?php

namespace App\Repository;

use App\Entity\MvtUploadTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MvtUploadTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method MvtUploadTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method MvtUploadTable[]    findAll()
 * @method MvtUploadTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MvtUploadTableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MvtUploadTable::class);
    }

    // /**
    //  * @return MvtUploadTable[] Returns an array of MvtUploadTable objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MvtUploadTable
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
