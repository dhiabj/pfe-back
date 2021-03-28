<?php

namespace App\service;

use App\Entity\AccountType;
use App\Entity\Category;
use App\Entity\Member;
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
        $operation = $this->em->getRepository(Operation::class)->find(substr($line[$i], 0, 2));
        $value = $this->em->getRepository(Value::class)->find(substr($line[$i], 2, 12));
        $deliveryMember = $this->em->getRepository(Member::class)->find(substr($line[$i], 30, 3));
        $deliveredAccount = $this->em->getRepository(AccountType::class)->find(substr($line[$i], 41, 2));
        $deliveredCategory = $this->em->getRepository(Category::class)->find(substr($line[$i], 43, 3));

        if (!$operation) {
            $operation = new Operation();
            $operation->setOperationCode(substr($line[$i], 0, 2));
            $this->em->persist($operation);
            $this->em->flush();
        }
        if (!$value) {
            $value = new Value();
            $value->setIsin(substr($line[$i], 2, 12));
            $this->em->persist($value);
            $this->em->flush();
        }
        if (!$deliveryMember) {
            $deliveryMember = new Member();
            $deliveryMember->setMembershipCode(substr($line[$i], 30, 3));
            $this->em->persist($deliveryMember);
            $this->em->flush();
        }
        $deliveredMember = $this->em->getRepository(Member::class)->find(substr($line[$i], 38, 3));
        if (!$deliveredMember) {
            $deliveredMember = new Member();
            $deliveredMember->setMembershipCode(substr($line[$i], 38, 3));
            $this->em->persist($deliveredMember);
            $this->em->flush();
        }
        if (!$deliveredAccount) {
            $deliveredAccount = new AccountType();
            $deliveredAccount->setNatureCode(substr($line[$i], 41, 2));
            $this->em->persist($deliveredAccount);
            $this->em->flush();
        }
        $deliveryAccount = $this->em->getRepository(AccountType::class)->find(substr($line[$i], 33, 2));
        if (!$deliveryAccount) {
            $deliveryAccount = new AccountType();
            $deliveryAccount->setNatureCode(substr($line[$i], 33, 2));
            $this->em->persist($deliveryAccount);
            $this->em->flush();
        }
        if (!$deliveredCategory) {
            $deliveredCategory = new Category();
            $deliveredCategory->setCategoryCode(substr($line[$i], 43, 3));
            $this->em->persist($deliveredCategory);
            $this->em->flush();
        }
        $deliveryCategory = $this->em->getRepository(Category::class)->find(substr($line[$i], 35, 3));
        if (!$deliveryCategory) {
            $deliveryCategory = new Category();
            $deliveryCategory->setCategoryCode(substr($line[$i], 35, 3));
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
