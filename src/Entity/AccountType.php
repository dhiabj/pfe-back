<?php

namespace App\Entity;

use App\Repository\AccountTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AccountTypeRepository::class)
 */
class AccountType
{


    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $NatureCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $NatureAccountLabel;

    /**
     * @ORM\OneToMany(targetEntity="Stock",mappedBy="NatureCode")
     * @ORM\JoinColumn(name="stock_id", referencedColumnName="id")
     */
    private $Stocks;

    /**
     * @ORM\OneToMany(targetEntity="Mouvement",mappedBy="DeliveredAccountType")
     * @ORM\JoinColumn(name="mouvement_id", referencedColumnName="id")

     */
    private $DeliveredAccountTypeMouvements;

    /**
     * @ORM\OneToMany(targetEntity="Mouvement",mappedBy="DeliveryAccountType")
     * @ORM\JoinColumn(name="mouvement_id", referencedColumnName="id")
     */
    private $DeliveryAccountTypeMouvements;

    public function __construct()
    {
        $this->Stocks = new ArrayCollection();
        $this->DeliveredAccountTypeMouvements = new ArrayCollection();
        $this->DeliveryAccountTypeMouvements = new ArrayCollection();
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

    public function getNatureAccountLabel(): ?string
    {
        return $this->NatureAccountLabel;
    }

    public function setNatureAccountLabel(?string $NatureAccountLabel): self
    {
        $this->NatureAccountLabel = $NatureAccountLabel;

        return $this;
    }

    /**
     * @return Collection|Stock[]
     */
    public function getStocks(): Collection
    {
        return $this->Stocks;
    }

    public function addStock(Stock $stock): self
    {
        if (!$this->Stocks->contains($stock)) {
            $this->Stocks[] = $stock;
            $stock->setNatureCode($this);
        }

        return $this;
    }

    public function removeStock(Stock $stock): self
    {
        if ($this->Stocks->removeElement($stock)) {
            // set the owning side to null (unless already changed)
            if ($stock->getNatureCode() === $this) {
                $stock->setNatureCode(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Mouvement[]
     */
    public function getDeliveredAccountTypeMouvements(): Collection
    {
        return $this->DeliveredAccountTypeMouvements;
    }

    public function addDeliveredAccountTypeMouvement(Mouvement $deliveredAccountTypeMouvement): self
    {
        if (!$this->DeliveredAccountTypeMouvements->contains($deliveredAccountTypeMouvement)) {
            $this->DeliveredAccountTypeMouvements[] = $deliveredAccountTypeMouvement;
            $deliveredAccountTypeMouvement->setDeliveredAccountType($this);
        }

        return $this;
    }

    public function removeDeliveredAccountTypeMouvement(Mouvement $deliveredAccountTypeMouvement): self
    {
        if ($this->DeliveredAccountTypeMouvements->removeElement($deliveredAccountTypeMouvement)) {
            // set the owning side to null (unless already changed)
            if ($deliveredAccountTypeMouvement->getDeliveredAccountType() === $this) {
                $deliveredAccountTypeMouvement->setDeliveredAccountType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Mouvement[]
     */
    public function getDeliveryAccountTypeMouvements(): Collection
    {
        return $this->DeliveryAccountTypeMouvements;
    }

    public function addDeliveryAccountTypeMouvement(Mouvement $deliveryAccountTypeMouvement): self
    {
        if (!$this->DeliveryAccountTypeMouvements->contains($deliveryAccountTypeMouvement)) {
            $this->DeliveryAccountTypeMouvements[] = $deliveryAccountTypeMouvement;
            $deliveryAccountTypeMouvement->setDeliveryAccountType($this);
        }

        return $this;
    }

    public function removeDeliveryAccountTypeMouvement(Mouvement $deliveryAccountTypeMouvement): self
    {
        if ($this->DeliveryAccountTypeMouvements->removeElement($deliveryAccountTypeMouvement)) {
            // set the owning side to null (unless already changed)
            if ($deliveryAccountTypeMouvement->getDeliveryAccountType() === $this) {
                $deliveryAccountTypeMouvement->setDeliveryAccountType(null);
            }
        }

        return $this;
    }
}
