<?php

namespace App\service;

use App\Entity\AccountType;
use App\Entity\Category;
use App\Entity\Member;
use App\Entity\MemberType;
use App\Entity\Mouvement;
use App\Entity\Operation;
use App\Entity\Value;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class MouvementService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function AddMouvement($line, $i)
    {
        $codeOp = substr($line[$i], 0, 2);
        $operation = $this->em->getRepository(Operation::class)->findOneBy(['OperationCode' => $codeOp]);
        if (!$operation) {
            $operation = new Operation();
            $operation->setOperationCode($codeOp);
            $this->em->persist($operation);
            $this->em->flush();
        }

        $codeVal = substr($line[$i], 2, 12);
        $value = $this->em->getRepository(Value::class)->findOneBy(['Isin' => $codeVal]);
        if (!$value) {
            $value = new Value();
            $value->setIsin($codeVal);
            $this->em->persist($value);
            $this->em->flush();
        }

        $dymc = substr($line[$i], 30, 3);
        $deliveryMember = $this->em->getRepository(Member::class)->findOneBy(['MembershipCode' => $dymc]);

        $mt = "-";
        $mtype = $this->em->getRepository(MemberType::class)->findOneBy(['MemberTypeCode' => $mt]);
        if (!$mtype) {
            $mtype = new MemberType();
            $mtype->setMemberTypeCode($mt);
            $this->em->persist($mtype);
            $this->em->flush();
        }

        if (!$deliveryMember) {
            $deliveryMember = new Member();
            $deliveryMember->setMembershipCode($dymc);
            $deliveryMember->setMemberType($mtype);
            $this->em->persist($deliveryMember);
            $this->em->flush();
        }

        $dync = substr($line[$i], 33, 2);
        $deliveryAccount = $this->em->getRepository(AccountType::class)->findOneBy(['NatureCode' => $dync]);
        if (!$deliveryAccount) {
            $deliveryAccount = new AccountType();
            $deliveryAccount->setNatureCode($dync);
            $this->em->persist($deliveryAccount);
            $this->em->flush();
        }

        $dedmc = substr($line[$i], 38, 3);
        $deliveredMember = $this->em->getRepository(Member::class)->findOneBy(['MembershipCode' => $dedmc]);
        if (!$deliveredMember) {
            $deliveredMember = new Member();
            $deliveredMember->setMembershipCode($dedmc);
            $deliveredMember->setMemberType($mtype);
            $this->em->persist($deliveredMember);
            $this->em->flush();
        }

        $dednc = substr($line[$i], 41, 2);
        $deliveredAccount = $this->em->getRepository(AccountType::class)->findOneBy(['NatureCode' => $dednc]);
        if (!$deliveredAccount) {
            $deliveredAccount = new AccountType();
            $deliveredAccount->setNatureCode($dednc);
            $this->em->persist($deliveredAccount);
            $this->em->flush();
        }

        $dedcc = substr($line[$i], 43, 3);
        $deliveredCategory = $this->em->getRepository(Category::class)->findOneBy(['CategoryCode' => $dedcc]);
        if (!$deliveredCategory) {
            $deliveredCategory = new Category();
            $deliveredCategory->setCategoryCode($dedcc);
            $this->em->persist($deliveredCategory);
            $this->em->flush();
        }

        $dycc = substr($line[$i], 35, 3);
        $deliveryCategory = $this->em->getRepository(Category::class)->findOneBy(['CategoryCode' => $dycc]);
        if (!$deliveryCategory) {
            $deliveryCategory = new Category();
            $deliveryCategory->setCategoryCode($dycc);
            $this->em->persist($deliveryCategory);
            $this->em->flush();
        }

        $mouvement = new Mouvement();
        $mouvement->setOperationCode($operation);
        $mouvement->setIsin($value);
        $StockExchangeDate = new DateTime();
        $AccountingDate = new DateTime();
        $mouvement->setStockExchangeDate($StockExchangeDate->setDate(substr($line[$i], 18, 4), substr($line[$i], 16, 2), substr($line[$i], 14, 2)));
        $mouvement->setAccountingDate($AccountingDate->setDate(substr($line[$i], 26, 4), substr($line[$i], 24, 2), substr($line[$i], 22, 2)));
        $mouvement->setDeliveryMemberCode($deliveryMember);
        $mouvement->setDeliveryAccountType($deliveryAccount);
        $mouvement->setDeliveryCategoryCredit($deliveryCategory);
        $mouvement->setDeliveredMemberCode($deliveredMember);
        $mouvement->setDeliveredAccountType($deliveredAccount);
        $mouvement->setDeliveredCategoryCredit($deliveredCategory);
        $mouvement->setTitlesNumber(substr($line[$i], 46, 10));
        $mouvement->setAmount(substr($line[$i], 56, 15));
        $this->em->persist($mouvement);
    }
}
