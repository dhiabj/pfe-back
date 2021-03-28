<?php

namespace App\Entity;

use App\Repository\ValueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ValueRepository::class)
 */
class Value
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=12, nullable=true)
     */
    private $Isin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ValueLabel;

    /**
     * @ORM\OneToMany(targetEntity="Stock",mappedBy="Isin")
     * @ORM\JoinColumn(name="stock_id", referencedColumnName="id")
     */
    private $Stocks;

    /**
     * @ORM\OneToMany(targetEntity="Mouvement",mappedBy="Isin")
     * @ORM\JoinColumn(name="mouvement_id", referencedColumnName="id")
     */
    private $Mouvements;

    public function __construct()
    {
        $this->Stocks = new ArrayCollection();
        $this->Mouvements = new ArrayCollection();
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

    public function getValueLabel(): ?string
    {
        return $this->ValueLabel;
    }

    public function setValueLabel(?string $ValueLabel): self
    {
        $this->ValueLabel = $ValueLabel;

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
            $stock->setIsin($this);
        }

        return $this;
    }

    public function removeStock(Stock $stock): self
    {
        if ($this->Stocks->removeElement($stock)) {
            // set the owning side to null (unless already changed)
            if ($stock->getIsin() === $this) {
                $stock->setIsin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Mouvement[]
     */
    public function getMouvements(): Collection
    {
        return $this->Mouvements;
    }

    public function addMouvement(Mouvement $mouvement): self
    {
        if (!$this->Mouvements->contains($mouvement)) {
            $this->Mouvements[] = $mouvement;
            $mouvement->setIsin($this);
        }

        return $this;
    }

    public function removeMouvement(Mouvement $mouvement): self
    {
        if ($this->Mouvements->removeElement($mouvement)) {
            // set the owning side to null (unless already changed)
            if ($mouvement->getIsin() === $this) {
                $mouvement->setIsin(null);
            }
        }

        return $this;
    }
}
