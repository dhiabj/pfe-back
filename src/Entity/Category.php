<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{


    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=3)
     */
    private $CategoryCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $CategoryLabel;

    /**
     * @ORM\OneToMany(targetEntity="Stock",mappedBy="CategoryCode")
     * @ORM\JoinColumn(name="stock_id", referencedColumnName="id")
     */
    private $Stocks;

    /**
     * @ORM\OneToMany(targetEntity="Mouvement",mappedBy="DeliveredCategoryCredit")
     * @ORM\JoinColumn(name="mouvement_id", referencedColumnName="id")
     */
    private $DeliveredCategoryMouvements;

    /**
     * @ORM\OneToMany(targetEntity="Mouvement",mappedBy="DeliveryCategoryCredit")
     * @ORM\JoinColumn(name="mouvement_id", referencedColumnName="id")
     */
    private $DeliveryCategoryMouvements;

    public function __construct()
    {
        $this->Stocks = new ArrayCollection();
        $this->DeliveredCategoryMouvements = new ArrayCollection();
        $this->DeliveryCategoryMouvements = new ArrayCollection();
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

    public function getCategoryLabel(): ?string
    {
        return $this->CategoryLabel;
    }

    public function setCategoryLabel(?string $CategoryLabel): self
    {
        $this->CategoryLabel = $CategoryLabel;

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
            $stock->setCategoryCode($this);
        }

        return $this;
    }

    public function removeStock(Stock $stock): self
    {
        if ($this->Stocks->removeElement($stock)) {
            // set the owning side to null (unless already changed)
            if ($stock->getCategoryCode() === $this) {
                $stock->setCategoryCode(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Mouvement[]
     */
    public function getDeliveredCategoryMouvements(): Collection
    {
        return $this->DeliveredCategoryMouvements;
    }

    public function addDeliveredCategoryMouvement(Mouvement $deliveredCategoryMouvement): self
    {
        if (!$this->DeliveredCategoryMouvements->contains($deliveredCategoryMouvement)) {
            $this->DeliveredCategoryMouvements[] = $deliveredCategoryMouvement;
            $deliveredCategoryMouvement->setDeliveredCategoryCredit($this);
        }

        return $this;
    }

    public function removeDeliveredCategoryMouvement(Mouvement $deliveredCategoryMouvement): self
    {
        if ($this->DeliveredCategoryMouvements->removeElement($deliveredCategoryMouvement)) {
            // set the owning side to null (unless already changed)
            if ($deliveredCategoryMouvement->getDeliveredCategoryCredit() === $this) {
                $deliveredCategoryMouvement->setDeliveredCategoryCredit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Mouvement[]
     */
    public function getDeliveryCategoryMouvements(): Collection
    {
        return $this->DeliveryCategoryMouvements;
    }

    public function addDeliveryCategoryMouvement(Mouvement $deliveryCategoryMouvement): self
    {
        if (!$this->DeliveryCategoryMouvements->contains($deliveryCategoryMouvement)) {
            $this->DeliveryCategoryMouvements[] = $deliveryCategoryMouvement;
            $deliveryCategoryMouvement->setDeliveryCategoryCredit($this);
        }

        return $this;
    }

    public function removeDeliveryCategoryMouvement(Mouvement $deliveryCategoryMouvement): self
    {
        if ($this->DeliveryCategoryMouvements->removeElement($deliveryCategoryMouvement)) {
            // set the owning side to null (unless already changed)
            if ($deliveryCategoryMouvement->getDeliveryCategoryCredit() === $this) {
                $deliveryCategoryMouvement->setDeliveryCategoryCredit(null);
            }
        }

        return $this;
    }
}
