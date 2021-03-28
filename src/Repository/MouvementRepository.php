<?php

namespace App\Repository;

use App\Entity\Mouvement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
        $code_valeur,
        $code_adherent,
        $nature_compte,
        $accounting_date,
        $stock_exchange_date
    ) {
        return $this->createQueryBuilder('m')
            ->select('m.id,m.AccountingDate,m.Amount,m.StockExchangeDate,m.TitlesNumber,oc.OperationCode,
            dymc.MembershipCode as DeliveryMemberCode,dedmc.MembershipCode as DeliveredMemberCode,
            i.Isin,dyat.NatureCode as DeliveryAccountType,dedat.NatureCode as DeliveredAccountType,
            dycc.CategoryCode as DeliveryCategoryCredit,dedcc.CategoryCode as DeliveredCategoryCredit')
            ->leftJoin('m.OperationCode', 'oc')
            ->leftJoin('m.DeliveryMemberCode', 'dymc')
            ->leftJoin('m.DeliveredMemberCode', 'dedmc')
            ->leftJoin('m.Isin', 'i')
            ->leftJoin('m.DeliveryAccountType', 'dyat')
            ->leftJoin('m.DeliveredAccountType', 'dedat')
            ->leftJoin('m.DeliveryCategoryCredit', 'dycc')
            ->leftJoin('m.DeliveredCategoryCredit', 'dedcc')
            ->where('i.Isin like :code_valeur')
            ->setParameter('code_valeur', '%' . $code_valeur . '%')
            ->andWhere("dymc.MembershipCode like '%" . $code_adherent . "%' OR dedmc.MembershipCode like '%" . $code_adherent . "%'")
            ->andWhere("dyat.NatureCode like  '%" . $nature_compte . "%' OR dedat.NatureCode like '%" . $nature_compte . "%'")
            ->andWhere('m.StockExchangeDate like :stock_exchange_date')
            ->setParameter('stock_exchange_date', '%' . $stock_exchange_date . '%')
            ->andWhere('m.AccountingDate like :accounting_date')
            ->setParameter('accounting_date', '%' . $accounting_date . '%')
            ->getQuery()
            ->getArrayResult();
    }


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
