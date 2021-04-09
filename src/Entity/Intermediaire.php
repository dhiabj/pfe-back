<?php

namespace App\Entity;

use App\Repository\IntermediaireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IntermediaireRepository::class)
 */
class Intermediaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date",nullable=true)
     */
    private $TransactionDate;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $ContractNumber;

    /**
     * @ORM\Column(type="string", length=1, nullable=true)
     */
    private $Direction;

    /**
     * @ORM\ManyToOne(targetEntity=Value::class, inversedBy="intermediaires")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $ValueCode;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $ValueLabel;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $ValueCharacteristic;

    /**
     * @ORM\ManyToOne(targetEntity=Market::class, inversedBy="intermediaires")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $Market;

    /**
     * @ORM\ManyToOne(targetEntity=Profit::class, inversedBy="intermediaires")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $Profit;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $Client;

    /**
     * @ORM\ManyToOne(targetEntity=IntermAccount::class, inversedBy="intermediaires")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $AccountType;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $Country;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $Quantity;

    /**
     * @ORM\Column(type="string", length=7, nullable=true)
     */
    private $Cours;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $IntermediaireCode;

    /**
     * @ORM\ManyToOne(targetEntity=Reglement::class, inversedBy="intermediaires")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $Reglement;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $Commission;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTransactionDate(): ?\DateTimeInterface
    {
        return $this->TransactionDate;
    }

    public function setTransactionDate(?\DateTimeInterface $TransactionDate): self
    {
        $this->TransactionDate = $TransactionDate;

        return $this;
    }

    public function getContractNumber(): ?string
    {
        return $this->ContractNumber;
    }

    public function setContractNumber(?string $ContractNumber): self
    {
        $this->ContractNumber = $ContractNumber;

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

    public function getValueLabel(): ?string
    {
        return $this->ValueLabel;
    }

    public function setValueLabel(?string $ValueLabel): self
    {
        $this->ValueLabel = $ValueLabel;

        return $this;
    }

    public function getValueCharacteristic(): ?string
    {
        return $this->ValueCharacteristic;
    }

    public function setValueCharacteristic(?string $ValueCharacteristic): self
    {
        $this->ValueCharacteristic = $ValueCharacteristic;

        return $this;
    }

    public function getClient(): ?string
    {
        return $this->Client;
    }

    public function setClient(?string $Client): self
    {
        $this->Client = $Client;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->Country;
    }

    public function setCountry(?string $Country): self
    {
        $this->Country = $Country;

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

    public function getCours(): ?string
    {
        return $this->Cours;
    }

    public function setCours(?string $Cours): self
    {
        $this->Cours = $Cours;

        return $this;
    }

    public function getIntermediaireCode(): ?string
    {
        return $this->IntermediaireCode;
    }

    public function setIntermediaireCode(?string $IntermediaireCode): self
    {
        $this->IntermediaireCode = $IntermediaireCode;

        return $this;
    }

    public function getCommission(): ?string
    {
        return $this->Commission;
    }

    public function setCommission(?string $Commission): self
    {
        $this->Commission = $Commission;

        return $this;
    }

    public function getValueCode(): ?Value
    {
        return $this->ValueCode;
    }

    public function setValueCode(?Value $ValueCode): self
    {
        $this->ValueCode = $ValueCode;

        return $this;
    }

    public function getMarket(): ?Market
    {
        return $this->Market;
    }

    public function setMarket(?Market $Market): self
    {
        $this->Market = $Market;

        return $this;
    }

    public function getProfit(): ?Profit
    {
        return $this->Profit;
    }

    public function setProfit(?Profit $Profit): self
    {
        $this->Profit = $Profit;

        return $this;
    }

    public function getAccountType(): ?IntermAccount
    {
        return $this->AccountType;
    }

    public function setAccountType(?IntermAccount $AccountType): self
    {
        $this->AccountType = $AccountType;

        return $this;
    }

    public function getReglement(): ?Reglement
    {
        return $this->Reglement;
    }

    public function setReglement(?Reglement $Reglement): self
    {
        $this->Reglement = $Reglement;

        return $this;
    }
}
