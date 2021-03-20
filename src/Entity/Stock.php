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
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $MembershipCode;

    /**
     * @ORM\Column(type="string", length=12, nullable=true)
     */
    private $Isin;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $NatureCode;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
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

    public function getMembershipCode(): ?int
    {
        return $this->MembershipCode;
    }

    public function setMembershipCode(?int $MembershipCode): self
    {
        $this->MembershipCode = $MembershipCode;

        return $this;
    }

    public function getIsin(): ?string
    {
        return $this->Isin;
    }

    public function setIsin(?string $Isin): self
    {
        $this->Isin = $Isin;

        return $this;
    }

    public function getNatureCode(): ?string
    {
        return $this->NatureCode;
    }

    public function setNatureCode(?string $NatureCode): self
    {
        $this->NatureCode = $NatureCode;

        return $this;
    }

    public function getCategoryCode(): ?string
    {
        return $this->CategoryCode;
    }

    public function setCategoryCode(?string $CategoryCode): self
    {
        $this->CategoryCode = $CategoryCode;

        return $this;
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
}
