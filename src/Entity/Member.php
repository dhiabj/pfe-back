<?php

namespace App\Entity;

use App\Repository\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=MemberRepository::class)
 */
class Member
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=3)
     */
    private $MembershipCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $MemberName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $MemberType;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $UpdateDate;

    /**
     * @ORM\OneToMany(targetEntity="Stock",mappedBy="MembershipCode")
     * @ORM\JoinColumn(name="stock_id", referencedColumnName="id")
     */
    private $Stocks;

    /**
     * @ORM\OneToMany(targetEntity="Mouvement",mappedBy="DeliveredMemberCode")
     * @ORM\JoinColumn(name="mouvement_id", referencedColumnName="id")
     */
    private $DeliveredMemberMouvements;

    /**
     * @ORM\OneToMany(targetEntity="Mouvement",mappedBy="DeliveryMemberCode")
     * @ORM\JoinColumn(name="mouvement_id", referencedColumnName="id")
     */
    private $DeliveryMemberMouvements;

    public function __construct()
    {
        $this->Stocks = new ArrayCollection();
        $this->DeliveredMemberMouvements = new ArrayCollection();
        $this->DeliveryMemberMouvements = new ArrayCollection();
    }

    public function getMembershipCode(): ?string
    {
        return $this->MembershipCode;
    }

    public function setMembershipCode(?string $MembershipCode): self
    {
        $this->MembershipCode = $MembershipCode;

        return $this;
    }

    public function getMemberName(): ?string
    {
        return $this->MemberName;
    }

    public function setMemberName(?string $MemberName): self
    {
        $this->MemberName = $MemberName;

        return $this;
    }

    public function getMemberType(): ?string
    {
        return $this->MemberType;
    }

    public function setMemberType(?string $MemberType): self
    {
        $this->MemberType = $MemberType;

        return $this;
    }

    public function getUpdateDate(): ?\DateTimeInterface
    {
        return $this->UpdateDate;
    }

    public function setUpdateDate(?\DateTimeInterface $UpdateDate): self
    {
        $this->UpdateDate = $UpdateDate;

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
            $stock->setMembershipCode($this);
        }

        return $this;
    }

    public function removeStock(Stock $stock): self
    {
        if ($this->Stocks->removeElement($stock)) {
            // set the owning side to null (unless already changed)
            if ($stock->getMembershipCode() === $this) {
                $stock->setMembershipCode(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Mouvement[]
     */
    public function getDeliveredMemberMouvements(): Collection
    {
        return $this->DeliveredMemberMouvements;
    }

    public function addDeliveredMemberMouvement(Mouvement $deliveredMemberMouvement): self
    {
        if (!$this->DeliveredMemberMouvements->contains($deliveredMemberMouvement)) {
            $this->DeliveredMemberMouvements[] = $deliveredMemberMouvement;
            $deliveredMemberMouvement->setDeliveredMemberCode($this);
        }

        return $this;
    }

    public function removeDeliveredMemberMouvement(Mouvement $deliveredMemberMouvement): self
    {
        if ($this->DeliveredMemberMouvements->removeElement($deliveredMemberMouvement)) {
            // set the owning side to null (unless already changed)
            if ($deliveredMemberMouvement->getDeliveredMemberCode() === $this) {
                $deliveredMemberMouvement->setDeliveredMemberCode(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Mouvement[]
     */
    public function getDeliveryMemberMouvements(): Collection
    {
        return $this->DeliveryMemberMouvements;
    }

    public function addDeliveryMemberMouvement(Mouvement $deliveryMemberMouvement): self
    {
        if (!$this->DeliveryMemberMouvements->contains($deliveryMemberMouvement)) {
            $this->DeliveryMemberMouvements[] = $deliveryMemberMouvement;
            $deliveryMemberMouvement->setDeliveryMemberCode($this);
        }

        return $this;
    }

    public function removeDeliveryMemberMouvement(Mouvement $deliveryMemberMouvement): self
    {
        if ($this->DeliveryMemberMouvements->removeElement($deliveryMemberMouvement)) {
            // set the owning side to null (unless already changed)
            if ($deliveryMemberMouvement->getDeliveryMemberCode() === $this) {
                $deliveryMemberMouvement->setDeliveryMemberCode(null);
            }
        }

        return $this;
    }
}
