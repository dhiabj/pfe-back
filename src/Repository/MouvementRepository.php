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
        $ValueCode,
        $OperationCode,
        $AccountingDate,
        $StockExchangeDate,
        $DeliveryMemberCode,
        $DeliveredMemberCode
    ) {
        return $this->createQueryBuilder('m')
            ->leftJoin('m.OperationCode', 'oc')
            ->addSelect('PARTIAL oc.{id,OperationCode,OperationLabel}')
            ->leftJoin('m.Isin', 'v')
            ->addSelect('PARTIAL v.{id,Isin,ValueLabel}')
            ->leftJoin('m.DeliveryMemberCode', 'dymc')
            ->addSelect('PARTIAL dymc.{id,MembershipCode,MemberName}')
            ->leftJoin('m.DeliveredMemberCode', 'dedmc')
            ->addSelect('PARTIAL dedmc.{id,MembershipCode,MemberName}')
            ->where('v.Isin like :ValueCode')
            ->setParameter('ValueCode', '%' . $ValueCode . '%')
            ->andWhere('oc.OperationCode like :OperationCode')
            ->setParameter('OperationCode', '%' . $OperationCode . '%')
            ->andWhere('dymc.MembershipCode like :DeliveryMemberCode')
            ->setParameter('DeliveryMemberCode', '%' . $DeliveryMemberCode . '%')
            ->andWhere('dedmc.MembershipCode like :DeliveredMemberCode')
            ->setParameter('DeliveredMemberCode', '%' . $DeliveredMemberCode . '%')
            ->andWhere('m.StockExchangeDate like :StockExchangeDate')
            ->setParameter('StockExchangeDate', '%' . $StockExchangeDate . '%')
            ->andWhere('m.AccountingDate like :AccountingDate')
            ->setParameter('AccountingDate', '%' . $AccountingDate . '%')
            ->getQuery()
            ->getArrayResult(Query::HYDRATE_ARRAY);
    }

    public function findSum(
        $ValueCode,
        $OperationCode,
        $AccountingDate,
        $StockExchangeDate,
        $DeliveryMemberCode,
        $DeliveredMemberCode
    ) {
        return $this->createQueryBuilder('m')
            ->leftJoin('m.OperationCode', 'oc')
            ->leftJoin('m.Isin', 'v')
            ->leftJoin('m.DeliveryMemberCode', 'dymc')
            ->leftJoin('m.DeliveredMemberCode', 'dedmc')
            ->select('sum(m.Amount) as AmountTotal')
            ->addSelect('sum(m.TitlesNumber) as TitlesTotal')
            ->where('v.Isin like :ValueCode')
            ->setParameter('ValueCode', '%' . $ValueCode . '%')
            ->andWhere('oc.OperationCode like :OperationCode')
            ->setParameter('OperationCode', '%' . $OperationCode . '%')
            ->andWhere('dymc.MembershipCode like :DeliveryMemberCode')
            ->setParameter('DeliveryMemberCode', '%' . $DeliveryMemberCode . '%')
            ->andWhere('dedmc.MembershipCode like :DeliveredMemberCode')
            ->setParameter('DeliveredMemberCode', '%' . $DeliveredMemberCode . '%')
            ->andWhere('m.StockExchangeDate like :StockExchangeDate')
            ->setParameter('StockExchangeDate', '%' . $StockExchangeDate . '%')
            ->andWhere('m.AccountingDate like :AccountingDate')
            ->setParameter('AccountingDate', '%' . $AccountingDate . '%')
            ->getQuery()
            ->getArrayResult();
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
