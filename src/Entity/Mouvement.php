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
     * @ORM\ManyToOne(targetEntity="Operation",inversedBy="Mouvements")
     * @ORM\JoinColumn(name="operation_code", referencedColumnName="operation_code", onDelete="SET NULL")
     */
    private $OperationCode;

    /**
     * @ORM\ManyToOne(targetEntity="Value",inversedBy="Mouvements")
     * @ORM\JoinColumn(name="isin", referencedColumnName="isin", onDelete="SET NULL")
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
     * @ORM\ManyToOne(targetEntity="Member",inversedBy="DeliveryMemberMouvements")
     * @ORM\JoinColumn(name="delivery_member_code", referencedColumnName="membership_code", onDelete="SET NULL")
     */
    private $DeliveryMemberCode;

    /**
     * @ORM\ManyToOne(targetEntity="AccountType",inversedBy="DeliveryAccountTypeMouvements")
     * @ORM\JoinColumn(name="delivery_account_type", referencedColumnName="nature_code", onDelete="SET NULL")
     */
    private $DeliveryAccountType;

    /**
     * @ORM\ManyToOne(targetEntity="Category",inversedBy="DeliveryCategoryMouvements")
     * @ORM\JoinColumn(name="delivery_category_credit", referencedColumnName="category_code", onDelete="SET NULL")
     */
    private $DeliveryCategoryCredit;

    /**
     * @ORM\ManyToOne(targetEntity="Member",inversedBy="DeliveredMemberMouvements")
     * @ORM\JoinColumn(name="delivered_member_code", referencedColumnName="membership_code", onDelete="SET NULL")
     */
    private $DeliveredMemberCode;

    /**
     * @ORM\ManyToOne(targetEntity="AccountType",inversedBy="DeliveredAccountTypeMouvements")
     * @ORM\JoinColumn(name="delivered_account_type", referencedColumnName="nature_code", onDelete="SET NULL")
     */
    private $DeliveredAccountType;

    /**
     * @ORM\ManyToOne(targetEntity="Category",inversedBy="DeliveredCategoryMouvements")
     * @ORM\JoinColumn(name="delivered_category_credit", referencedColumnName="category_code", onDelete="SET NULL")
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

    public function getDeliveredCategoryCredit(): ?Category
    {
        return $this->DeliveredCategoryCredit;
    }

    public function setDeliveredCategoryCredit(?Category $DeliveredCategoryCredit): self
    {
        $this->DeliveredCategoryCredit = $DeliveredCategoryCredit;

        return $this;
    }

    public function getDeliveryCategoryCredit(): ?Category
    {
        return $this->DeliveryCategoryCredit;
    }

    public function setDeliveryCategoryCredit(?Category $DeliveryCategoryCredit): self
    {
        $this->DeliveryCategoryCredit = $DeliveryCategoryCredit;

        return $this;
    }

    public function getDeliveryAccountType(): ?AccountType
    {
        return $this->DeliveryAccountType;
    }

    public function setDeliveryAccountType(?AccountType $DeliveryAccountType): self
    {
        $this->DeliveryAccountType = $DeliveryAccountType;

        return $this;
    }

    public function getDeliveredAccountType(): ?AccountType
    {
        return $this->DeliveredAccountType;
    }

    public function setDeliveredAccountType(?AccountType $DeliveredAccountType): self
    {
        $this->DeliveredAccountType = $DeliveredAccountType;

        return $this;
    }

    public function getOperationCode(): ?Operation
    {
        return $this->OperationCode;
    }

    public function setOperationCode(?Operation $OperationCode): self
    {
        $this->OperationCode = $OperationCode;

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

    public function getDeliveryMemberCode(): ?Member
    {
        return $this->DeliveryMemberCode;
    }

    public function setDeliveryMemberCode(?Member $DeliveryMemberCode): self
    {
        $this->DeliveryMemberCode = $DeliveryMemberCode;

        return $this;
    }

    public function getDeliveredMemberCode(): ?Member
    {
        return $this->DeliveredMemberCode;
    }

    public function setDeliveredMemberCode(?Member $DeliveredMemberCode): self
    {
        $this->DeliveredMemberCode = $DeliveredMemberCode;

        return $this;
    }
}
