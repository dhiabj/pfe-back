<?php

namespace App\Entity;

use App\Repository\MouvementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MouvementRepository::class)
 */
class Mouvement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $OperationCode;

    /**
     * @ORM\Column(type="string", length=12, nullable=true)
     */
    private $Isin;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $StockExchangeDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $AccountingDate;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $DeliveryMemberCode;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $DeliveryAccountType;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $DeliveryCategoryCredit;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $DeliveredMemberCode;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $DeliveredAccountType;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $DeliveredCategoryCredit;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $TitlesNumber;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $Amount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOperationCode(): ?string
    {
        return $this->OperationCode;
    }

    public function setOperationCode(?string $OperationCode): self
    {
        $this->OperationCode = $OperationCode;

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

    public function getDeliveryMemberCode(): ?string
    {
        return $this->DeliveryMemberCode;
    }

    public function setDeliveryMemberCode(?string $DeliveryMemberCode): self
    {
        $this->DeliveryMemberCode = $DeliveryMemberCode;

        return $this;
    }

    public function getDeliveryAccountType(): ?string
    {
        return $this->DeliveryAccountType;
    }

    public function setDeliveryAccountType(?string $DeliveryAccountType): self
    {
        $this->DeliveryAccountType = $DeliveryAccountType;

        return $this;
    }

    public function getDeliveryCategoryCredit(): ?string
    {
        return $this->DeliveryCategoryCredit;
    }

    public function setDeliveryCategoryCredit(?string $DeliveryCategoryCredit): self
    {
        $this->DeliveryCategoryCredit = $DeliveryCategoryCredit;

        return $this;
    }

    public function getDeliveredMemberCode(): ?string
    {
        return $this->DeliveredMemberCode;
    }

    public function setDeliveredMemberCode(?string $DeliveredMemberCode): self
    {
        $this->DeliveredMemberCode = $DeliveredMemberCode;

        return $this;
    }

    public function getDeliveredAccountType(): ?string
    {
        return $this->DeliveredAccountType;
    }

    public function setDeliveredAccountType(?string $DeliveredAccountType): self
    {
        $this->DeliveredAccountType = $DeliveredAccountType;

        return $this;
    }

    public function getDeliveredCategoryCredit(): ?string
    {
        return $this->DeliveredCategoryCredit;
    }

    public function setDeliveredCategoryCredit(?string $DeliveredCategoryCredit): self
    {
        $this->DeliveredCategoryCredit = $DeliveredCategoryCredit;

        return $this;
    }

    public function getTitlesNumber(): ?string
    {
        return $this->TitlesNumber;
    }

    public function setTitlesNumber(?string $TitlesNumber): self
    {
        $this->TitlesNumber = $TitlesNumber;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->Amount;
    }

    public function setAmount(?string $Amount): self
    {
        $this->Amount = $Amount;

        return $this;
    }
}
