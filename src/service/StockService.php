<?php

namespace App\service;

use App\Entity\AccountType;
use App\Entity\Category;
use App\Entity\Member;
use App\Entity\MemberType;
use App\Entity\Stock;
use App\Entity\Value;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class StockService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function AddStock($line, $i)
    {
        $mt = "-";
        $mtype = $this->em->getRepository(MemberType::class)->findOneBy(['MemberTypeCode' => $mt]);
        if (!$mtype) {
            $mtype = new MemberType();
            $mtype->setMemberTypeCode($mt);
            $this->em->persist($mtype);
            $this->em->flush();
        }
        $mc = substr($line[$i], 0, 3);
        $member = $this->em->getRepository(Member::class)->findOneBy(['MembershipCode' => $mc]);
        if (!$member) {
            $member = new Member();
            $member->setMembershipCode($mc);
            $member->setMemberType($mtype);
            $this->em->persist($member);
            $this->em->flush();
        }
        $codeVal = substr($line[$i], 3, 12);
        $value = $this->em->getRepository(Value::class)->findOneBy(['Isin' => $codeVal]);
        if (!$value) {
            $value = new Value();
            $value->setIsin($codeVal);
            $this->em->persist($value);
            $this->em->flush();
        }
        $nc = substr($line[$i], 15, 2);
        $accountType = $this->em->getRepository(AccountType::class)->findOneBy(['NatureCode' => $nc]);
        if (!$accountType) {
            $accountType = new AccountType();
            $accountType->setNatureCode($nc);
            $this->em->persist($accountType);
            $this->em->flush();
        }
        $cc = substr($line[$i], 17, 3);
        $category = $this->em->getRepository(Category::class)->findOneBy(['CategoryCode' => $cc]);
        if (!$category) {
            $category = new Category();
            $category->setCategoryCode($cc);
            $this->em->persist($category);
            $this->em->flush();
        }
        $stock = new Stock();
        $stock->setMembershipCode($member);
        $stock->setIsin($value);
        $stock->setNatureCode($accountType);
        $stock->setCategoryCode($category);
        $stock->setQuantity(substr($line[$i], 20, 10));
        $stock->setDirection(substr($line[$i], 30, 1));
        $StockExchangeDate = new DateTime();
        $AccountingDate = new DateTime();
        $stock->setStockExchangeDate($StockExchangeDate->setDate(substr($line[$i], 35, 4), substr($line[$i], 33, 2), substr($line[$i], 31, 2)));
        $stock->setAccountingDate($AccountingDate->setDate(substr($line[$i], 43, 4), substr($line[$i], 41, 2), substr($line[$i], 39, 2)));
        $this->em->persist($stock);
    }
}
