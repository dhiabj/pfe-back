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
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=12, unique=true)
     */
    private $Isin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ValueLabel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Mnemonique;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $ValueType;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $NbTitresadmisBourse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $NbCodFlott;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $GroupCotation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $SuperSecteur;

    /**
     * @ORM\OneToMany(targetEntity=Mouvement::class, mappedBy="Isin")
     */
    private $mouvements;

    /**
     * @ORM\OneToMany(targetEntity=Stock::class, mappedBy="Isin")
     */
    private $stocks;

    public function __construct()
    {
        $this->mouvements = new ArrayCollection();
        $this->stocks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsin(): ?string
    {
        return $this->Isin;
    }

    public function setIsin(string $Isin): self
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

    public function getMnemonique(): ?string
    {
        return $this->Mnemonique;
    }

    public function setMnemonique(?string $Mnemonique): self
    {
        $this->Mnemonique = $Mnemonique;

        return $this;
    }

    public function getValueType(): ?string
    {
        return $this->ValueType;
    }

    public function setValueType(?string $ValueType): self
    {
        $this->ValueType = $ValueType;

        return $this;
    }

    public function getNbTitresadmisBourse(): ?string
    {
        return $this->NbTitresadmisBourse;
    }

    public function setNbTitresadmisBourse(?string $NbTitresadmisBourse): self
    {
        $this->NbTitresadmisBourse = $NbTitresadmisBourse;

        return $this;
    }

    public function getNbCodFlott(): ?string
    {
        return $this->NbCodFlott;
    }

    public function setNbCodFlott(?string $NbCodFlott): self
    {
        $this->NbCodFlott = $NbCodFlott;

        return $this;
    }

    public function getGroupCotation(): ?string
    {
        return $this->GroupCotation;
    }

    public function setGroupCotation(?string $GroupCotation): self
    {
        $this->GroupCotation = $GroupCotation;

        return $this;
    }

    public function getSuperSecteur(): ?string
    {
        return $this->SuperSecteur;
    }

    public function setSuperSecteur(?string $SuperSecteur): self
    {
        $this->SuperSecteur = $SuperSecteur;

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
            $mouvement->setIsin($this);
        }

        return $this;
    }

    public function removeMouvement(Mouvement $mouvement): self
    {
        if ($this->mouvements->removeElement($mouvement)) {
            // set the owning side to null (unless already changed)
            if ($mouvement->getIsin() === $this) {
                $mouvement->setIsin(null);
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
            $stock->setIsin($this);
        }

        return $this;
    }

    public function removeStock(Stock $stock): self
    {
        if ($this->stocks->removeElement($stock)) {
            // set the owning side to null (unless already changed)
            if ($stock->getIsin() === $this) {
                $stock->setIsin(null);
            }
        }

        return $this;
    }
}
