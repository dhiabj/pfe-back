<?php

namespace App\Repository;

use App\Entity\Mouvement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Mouvement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mouvement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mouvement[]    findAll()
 * @method Mouvement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MouvementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mouvement::class);
    }

    // /**
    //  * @return Mouvement[] Returns an array of Mouvement objects
    //  */

    public function findByAll(
        $startAccountingDate,
        $endAccountingDate,
        $startStockExchangeDate,
        $endStockExchangeDate,
        $ValueCode,
        $OperationCode,
        $DeliveryMemberCode,
        $DeliveredMemberCode
    ) {
        $qb = $this->createQueryBuilder('m')
            ->leftJoin('m.Isin', 'v')
            ->leftJoin('m.OperationCode', 'oc')
            ->leftJoin('m.DeliveryMemberCode', 'dymc')
            ->leftJoin('m.DeliveredMemberCode', 'dedmc')
            ->addSelect('PARTIAL oc.{id,OperationCode,OperationLabel}');
        // ->addSelect('PARTIAL v.{id,Isin,ValueLabel}')
        // ->addSelect('PARTIAL dymc.{id,MembershipCode,MemberName}')
        // ->addSelect('PARTIAL dedmc.{id,MembershipCode,MemberName}')
        if ($startStockExchangeDate && $endStockExchangeDate) {
            $qb->andWhere('m.StockExchangeDate BETWEEN :startStockExchangeDate AND :endStockExchangeDate')
                ->setParameter('startStockExchangeDate', $startStockExchangeDate)
                ->setParameter('endStockExchangeDate', $endStockExchangeDate);
        }
        if ($startAccountingDate && $endAccountingDate) {
            $qb->andWhere('m.AccountingDate BETWEEN :startAccountingDate AND :endAccountingDate')
                ->setParameter('startAccountingDate', $startAccountingDate)
                ->setParameter('endAccountingDate', $endAccountingDate);
        }
        if ($ValueCode) {
            $qb->andWhere('v.Isin like :ValueCode')
                ->setParameter('ValueCode', '%' . $ValueCode . '%');
        }
        if ($OperationCode) {
            $qb->andWhere('oc.OperationCode like :OperationCode')
                ->setParameter('OperationCode', '%' . $OperationCode . '%');
        }
        if ($DeliveryMemberCode) {
            $qb->andWhere('dymc.MembershipCode like :DeliveryMemberCode')
                ->setParameter('DeliveryMemberCode', '%' . $DeliveryMemberCode . '%');
        }
        if ($DeliveredMemberCode) {
            $qb->andWhere('dedmc.MembershipCode like :DeliveredMemberCode')
                ->setParameter('DeliveredMemberCode', '%' . $DeliveredMemberCode . '%');
        }
        return $qb->getQuery()
            ->getArrayResult(Query::HYDRATE_ARRAY);
    }

    // ->addSelect('PARTIAL operation.{id,OperationCode,OperationLabel}')
    // ->leftJoin('m.Isin', 'value')
    // ->addSelect('PARTIAL value.{id,Isin,ValueLabel}')
    // ->leftJoin('m.DeliveryMemberCode', 'member')
    // ->addSelect('PARTIAL member.{id,MembershipCode}')
    // ->leftJoin('m.DeliveredMemberCode', 'member1')
    // ->addSelect('PARTIAL member1.{id,MembershipCode}')
    // ->getQuery()
    // ->getArrayResult(Query::HYDRATE_ARRAY);

    /*
    public function findOneBySomeField($value): ?Mouvement
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
