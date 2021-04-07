<?php

namespace App\Repository;

use App\Entity\IntermAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method IntermAccount|null find($id, $lockMode = null, $lockVersion = null)
 * @method IntermAccount|null findOneBy(array $criteria, array $orderBy = null)
 * @method IntermAccount[]    findAll()
 * @method IntermAccount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IntermAccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IntermAccount::class);
    }

    // /**
    //  * @return IntermAccount[] Returns an array of IntermAccount objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?IntermAccount
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
