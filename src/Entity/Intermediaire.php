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
     * @ORM\Column(type="integer",nullable=true)
     */
    private $ContractNumber;

    /**
     * @ORM\Column(type="string", length=1,nullable=true)
     */
    private $Direction;

    /**
     * @ORM\Column(type="string", length=6,nullable=true)
     */
    private $ValueCode;

    /**
     * @ORM\Column(type="string", length=100,nullable=true)
     */
    private $ValueLabel;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $ValueCharacteristic;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $Market;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $Profit;

    /**
     * @ORM\Column(type="string", length=150,nullable=true)
     */
    private $Client;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $AccountType;

    /**
     * @ORM\Column(type="string", length=2,nullable=true)
     */
    private $Country;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $Quantity;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $Cours;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $IntermediaireCode;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $Reglement;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $Commission;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContractNumber(): ?int
    {
        return $this->ContractNumber;
    }

    public function setContractNumber(?int $ContractNumber): self
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

    public function getValueCode(): ?string
    {
        return $this->ValueCode;
    }

    public function setValueCode(?string $ValueCode): self
    {
        $this->ValueCode = $ValueCode;

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

    public function getValueCharacteristic(): ?int
    {
        return $this->ValueCharacteristic;
    }

    public function setValueCharacteristic(?int $ValueCharacteristic): self
    {
        $this->ValueCharacteristic = $ValueCharacteristic;

        return $this;
    }

    public function getMarket(): ?int
    {
        return $this->Market;
    }

    public function setMarket(?int $Market): self
    {
        $this->Market = $Market;

        return $this;
    }

    public function getProfit(): ?int
    {
        return $this->Profit;
    }

    public function setProfit(?int $Profit): self
    {
        $this->Profit = $Profit;

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

    public function getAccountType(): ?int
    {
        return $this->AccountType;
    }

    public function setAccountType(?int $AccountType): self
    {
        $this->AccountType = $AccountType;

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

    public function getQuantity(): ?int
    {
        return $this->Quantity;
    }

    public function setQuantity(?int $Quantity): self
    {
        $this->Quantity = $Quantity;

        return $this;
    }

    public function getCours(): ?int
    {
        return $this->Cours;
    }

    public function setCours(?int $Cours): self
    {
        $this->Cours = $Cours;

        return $this;
    }

    public function getIntermediaireCode(): ?int
    {
        return $this->IntermediaireCode;
    }

    public function setIntermediaireCode(?int $IntermediaireCode): self
    {
        $this->IntermediaireCode = $IntermediaireCode;

        return $this;
    }

    public function getReglement(): ?int
    {
        return $this->Reglement;
    }

    public function setReglement(?int $Reglement): self
    {
        $this->Reglement = $Reglement;

        return $this;
    }

    public function getCommission(): ?int
    {
        return $this->Commission;
    }

    public function setCommission(?int $Commission): self
    {
        $this->Commission = $Commission;

        return $this;
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
}
