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
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=3, unique=true)
     */
    private $CategoryCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $CategoryLabel;

    /**
     * @ORM\OneToMany(targetEntity=Mouvement::class, mappedBy="DeliveryCategoryCredit")
     */
    private $mouvements;

    /**
     * @ORM\OneToMany(targetEntity=Mouvement::class, mappedBy="DeliveredCategoryCredit")
     */
    private $mouvementl;

    /**
     * @ORM\OneToMany(targetEntity=Stock::class, mappedBy="CategoryCode")
     */
    private $stocks;

    public function __construct()
    {
        $this->mouvements = new ArrayCollection();
        $this->mouvementl = new ArrayCollection();
        $this->stocks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryCode(): ?string
    {
        return $this->CategoryCode;
    }

    public function setCategoryCode(string $CategoryCode): self
    {
        $this->CategoryCode = $CategoryCode;

        return $this;
    }

    public function getCategoryLabel(): ?string
    {
        return $this->CategoryLabel;
    }

    public function setCategoryLabel(string $CategoryLabel): self
    {
        $this->CategoryLabel = $CategoryLabel;

        return $this;
    }

    /**
     * @return Collection|Mouvement[]
     */
    public function getMouvements(): Collection
    {
        return $this->mouvements;
    }

    public function addMouvement(Mouvement $mouvement): self
    {
        if (!$this->mouvements->contains($mouvement)) {
            $this->mouvements[] = $mouvement;
            $mouvement->setDeliveryCategoryCredit($this);
        }

        return $this;
    }

    public function removeMouvement(Mouvement $mouvement): self
    {
        if ($this->mouvements->removeElement($mouvement)) {
            // set the owning side to null (unless already changed)
            if ($mouvement->getDeliveryCategoryCredit() === $this) {
                $mouvement->setDeliveryCategoryCredit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Mouvement[]
     */
    public function getMouvementl(): Collection
    {
        return $this->mouvementl;
    }

    public function addMouvementl(Mouvement $mouvementl): self
    {
        if (!$this->mouvementl->contains($mouvementl)) {
            $this->mouvementl[] = $mouvementl;
            $mouvementl->setDeliveredCategoryCredit($this);
        }

        return $this;
    }

    public function removeMouvementl(Mouvement $mouvementl): self
    {
        if ($this->mouvementl->removeElement($mouvementl)) {
            // set the owning side to null (unless already changed)
            if ($mouvementl->getDeliveredCategoryCredit() === $this) {
                $mouvementl->setDeliveredCategoryCredit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Stock[]
     */
    public function getStocks(): Collection
    {
        return $this->stocks;
    }

    public function addStock(Stock $stock): self
    {
        if (!$this->stocks->contains($stock)) {
            $this->stocks[] = $stock;
            $stock->setCategoryCode($this);
        }

        return $this;
    }

    public function removeStock(Stock $stock): self
    {
        if ($this->stocks->removeElement($stock)) {
            // set the owning side to null (unless already changed)
            if ($stock->getCategoryCode() === $this) {
                $stock->setCategoryCode(null);
            }
        }

        return $this;
    }
}
