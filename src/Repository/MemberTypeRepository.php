<?php

namespace App\Repository;

use App\Entity\MemberType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MemberType|null find($id, $lockMode = null, $lockVersion = null)
 * @method MemberType|null findOneBy(array $criteria, array $orderBy = null)
 * @method MemberType[]    findAll()
 * @method MemberType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemberTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MemberType::class);
    }

    // /**
    //  * @return MemberType[] Returns an array of MemberType objects
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
    public function findOneBySomeField($value): ?MemberType
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
