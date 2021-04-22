<?php

namespace App\Repository;

use App\Entity\Stock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Stock|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stock|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stock[]    findAll()
 * @method Stock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stock::class);
    }

    // /**
    //  * @return Stock[] Returns an array of Stock objects
    //  */

    public function findByAll(
        $AccountingDate,
        $StockExchangeDate,
        $ValueCode,
        $MembershipCode,
        $NatureCode
    ) {
        $qb = $this->createQueryBuilder('m')
            ->leftJoin('m.MembershipCode', 'mc')
            ->leftJoin('m.Isin', 'v')
            ->leftJoin('m.NatureCode', 'n')
            ->leftJoin('m.CategoryCode', 'c')
            ->addSelect('PARTIAL mc.{id,MembershipCode,MemberName}')
            ->addSelect('PARTIAL v.{id,Isin,ValueLabel}')
            ->addSelect('PARTIAL c.{id,CategoryCode,CategoryLabel}');
        if ($AccountingDate) {
            $qb->andWhere('m.AccountingDate like :AccountingDate')
                ->setParameter('AccountingDate', '%' . $AccountingDate . '%');
        }
        if ($StockExchangeDate) {
            $qb->andWhere('m.StockExchangeDate like :StockExchangeDate')
                ->setParameter('StockExchangeDate', '%' . $StockExchangeDate . '%');
        }
        if ($ValueCode) {
            $qb->andWhere('v.Isin like :ValueCode')
                ->setParameter('ValueCode', '%' . $ValueCode . '%');
        }
        if ($MembershipCode) {
            $qb->andWhere('mc.MembershipCode like :MembershipCode')
                ->setParameter('MembershipCode', '%' . $MembershipCode . '%');
        }
        if ($NatureCode) {
            $qb->andWhere('n.NatureCode like :NatureCode')
                ->setParameter('NatureCode', '%' . $NatureCode . '%');
        }
        return $qb->getQuery()
            ->getArrayResult(Query::HYDRATE_ARRAY);
    }

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
    public function findOneBySomeField($value): ?Stock
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
