<?php

namespace App\Entity;

use App\Repository\StockRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StockRepository::class)
 */
class Stock
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Member",inversedBy="Stocks")
     * @ORM\JoinColumn(name="membership_code", referencedColumnName="membership_code", onDelete="CASCADE")
     */
    private $MembershipCode;

    /**
     * @ORM\ManyToOne(targetEntity="Value",inversedBy="Stocks")
     * @ORM\JoinColumn(name="isin", referencedColumnName="isin", onDelete="CASCADE")
     */
    private $Isin;

    /**
     * @ORM\ManyToOne(targetEntity="AccountType",inversedBy="Stocks")
     * @ORM\JoinColumn(name="nature_code", referencedColumnName="nature_code", onDelete="CASCADE")
     */
    private $NatureCode;

    /**
     * @ORM\ManyToOne(targetEntity="Category",inversedBy="Stocks")
     * @ORM\JoinColumn(name="category_code", referencedColumnName="category_code", onDelete="CASCADE")
     */
    private $CategoryCode;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $Quantity;

    /**
     * @ORM\Column(type="string", length=1, nullable=true)
     */
    private $Direction;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $StockExchangeDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $AccountingDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?string
    {
        return $this->Quantity;
    }

    public function setQuantity(?string $Quantity): self
    {
        $this->Quantity = $Quantity;

        return $this;
    }

    public function getDirection(): ?string
    {
        return $this->Direction;
    }

    public function setDirection(?string $Direction): self
    {
        $this->Direction = $Direction;

        return $this;
    }

    public function getStockExchangeDate(): ?\DateTimeInterface
    {
        return $this->StockExchangeDate;
    }

    public function setStockExchangeDate(?\DateTimeInterface $StockExchangeDate): self
    {
        $this->StockExchangeDate = $StockExchangeDate;

        return $this;
    }

    public function getAccountingDate(): ?\DateTimeInterface
    {
        return $this->AccountingDate;
    }

    public function setAccountingDate(?\DateTimeInterface $AccountingDate): self
    {
        $this->AccountingDate = $AccountingDate;

        return $this;
    }

    public function getIsin(): ?Value
    {
        return $this->Isin;
    }

    public function setIsin(?Value $Isin): self
    {
        $this->Isin = $Isin;

        return $this;
    }

    public function getNatureCode(): ?AccountType
    {
        return $this->NatureCode;
    }

    public function setNatureCode(?AccountType $NatureCode): self
    {
        $this->NatureCode = $NatureCode;

        return $this;
    }

    public function getMembershipCode(): ?Member
    {
        return $this->MembershipCode;
    }

    public function setMembershipCode(?Member $MembershipCode): self
    {
        $this->MembershipCode = $MembershipCode;

        return $this;
    }

    public function getCategoryCode(): ?Category
    {
        return $this->CategoryCode;
    }

    public function setCategoryCode(?Category $CategoryCode): self
    {
        $this->CategoryCode = $CategoryCode;

        return $this;
    }
}
