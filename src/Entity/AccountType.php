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
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=2, unique=true)
     */
    private $NatureCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $NatureAccountLabel;

    /**
     * @ORM\OneToMany(targetEntity=Mouvement::class, mappedBy="DeliveredAccountType")
     */
    private $mouvements;

    /**
     * @ORM\OneToMany(targetEntity=Mouvement::class, mappedBy="DeliveryAccountType")
     */
    private $mouvementl;

    /**
     * @ORM\OneToMany(targetEntity=Stock::class, mappedBy="NatureCode")
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

    public function getNatureCode(): ?string
    {
        return $this->NatureCode;
    }

    public function setNatureCode(string $NatureCode): self
    {
        $this->NatureCode = $NatureCode;

        return $this;
    }

    public function getNatureAccountLabel(): ?string
    {
        return $this->NatureAccountLabel;
    }

    public function setNatureAccountLabel(string $NatureAccountLabel): self
    {
        $this->NatureAccountLabel = $NatureAccountLabel;

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
            $mouvement->setDeliveredAccountType($this);
        }

        return $this;
    }

    public function removeMouvement(Mouvement $mouvement): self
    {
        if ($this->mouvements->removeElement($mouvement)) {
            // set the owning side to null (unless already changed)
            if ($mouvement->getDeliveredAccountType() === $this) {
                $mouvement->setDeliveredAccountType(null);
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
            $mouvementl->setDeliveryAccountType($this);
        }

        return $this;
    }

    public function removeMouvementl(Mouvement $mouvementl): self
    {
        if ($this->mouvementl->removeElement($mouvementl)) {
            // set the owning side to null (unless already changed)
            if ($mouvementl->getDeliveryAccountType() === $this) {
                $mouvementl->setDeliveryAccountType(null);
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
            $stock->setNatureCode($this);
        }

        return $this;
    }

    public function removeStock(Stock $stock): self
    {
        if ($this->stocks->removeElement($stock)) {
            // set the owning side to null (unless already changed)
            if ($stock->getNatureCode() === $this) {
                $stock->setNatureCode(null);
            }
        }

        return $this;
    }
}
