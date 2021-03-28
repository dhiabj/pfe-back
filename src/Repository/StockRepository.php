<?php

namespace App\Repository;

use App\Entity\Stock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
        $code_valeur,
        $code_adherent,
        $nature_compte,
        $accounting_date,
        $stock_exchange_date
    ) {
        return $this->createQueryBuilder('m')
            ->select('m.id,m.Quantity,m.Direction,m.StockExchangeDate,m.AccountingDate,
            mc.MembershipCode,
            i.Isin,n.NatureCode,
            c.CategoryCode')
            ->leftJoin('m.MembershipCode', 'mc')
            ->leftJoin('m.Isin', 'i')
            ->leftJoin('m.NatureCode', 'n')
            ->leftJoin('m.CategoryCode', 'c')
            ->where('i.Isin like :code_valeur')
            ->setParameter('code_valeur', '%' . $code_valeur . '%')
            ->andWhere('mc.MembershipCode like :code_adherent')
            ->setParameter('code_adherent', '%' . $code_adherent . '%')
            ->andWhere('n.NatureCode like :nature_compte')
            ->setParameter('nature_compte', '%' . $nature_compte . '%')
            ->andWhere('m.StockExchangeDate like :stock_exchange_date')
            ->setParameter('stock_exchange_date', '%' . $stock_exchange_date . '%')
            ->andWhere('m.AccountingDate like :accounting_date')
            ->setParameter('accounting_date', '%' . $accounting_date . '%')
            ->getQuery()
            ->getArrayResult();
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
