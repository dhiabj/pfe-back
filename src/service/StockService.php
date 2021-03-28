<?php

namespace App\service;

use App\Entity\AccountType;
use App\Entity\Category;
use App\Entity\Member;
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
        $member = $this->em->getRepository(Member::class)->find(substr($line[$i], 0, 3));
        $value = $this->em->getRepository(Value::class)->find(substr($line[$i], 3, 12));
        $accountType = $this->em->getRepository(AccountType::class)->find(substr($line[$i], 15, 2));
        $category = $this->em->getRepository(Category::class)->find(substr($line[$i], 17, 3));

        if (!$member) {
            $member = new Member();
            $member->setMembershipCode(substr($line[$i], 0, 3));
            $this->em->persist($member);
            $this->em->flush();
        }
        if (!$value) {
            $value = new Value();
            $value->setIsin(substr($line[$i], 3, 12));
            $this->em->persist($value);
            $this->em->flush();
        }
        if (!$accountType) {
            $accountType = new AccountType();
            $accountType->setNatureCode(substr($line[$i], 15, 2));
            $this->em->persist($accountType);
            $this->em->flush();
        }

        if (!$category) {
            $category = new Category();
            $category->setCategoryCode(substr($line[$i], 17, 3));
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
