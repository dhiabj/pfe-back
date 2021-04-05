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
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=3, unique=true)
     */
    private $MembershipCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $MemberName;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $UpdateDate;

    /**
     * @ORM\ManyToOne(targetEntity=MemberType::class, inversedBy="members")
     * @ORM\JoinColumn(nullable=true)
     */
    private $MemberType;

    /**
     * @ORM\OneToMany(targetEntity=Mouvement::class, mappedBy="DeliveryMemberCode")
     */
    private $mouvements;

    /**
     * @ORM\OneToMany(targetEntity=Mouvement::class, mappedBy="DeliveredMemberCode")
     */
    private $mouvementl;

    /**
     * @ORM\OneToMany(targetEntity=Stock::class, mappedBy="MembershipCode")
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

    public function getMembershipCode(): ?string
    {
        return $this->MembershipCode;
    }

    public function setMembershipCode(string $MembershipCode): self
    {
        $this->MembershipCode = $MembershipCode;

        return $this;
    }

    public function getMemberName(): ?string
    {
        return $this->MemberName;
    }

    public function setMemberName(string $MemberName): self
    {
        $this->MemberName = $MemberName;

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

    public function getMemberType(): ?MemberType
    {
        return $this->MemberType;
    }

    public function setMemberType(?MemberType $MemberType): self
    {
        $this->MemberType = $MemberType;

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
            $mouvement->setDeliveryMemberCode($this);
        }

        return $this;
    }

    public function removeMouvement(Mouvement $mouvement): self
    {
        if ($this->mouvements->removeElement($mouvement)) {
            // set the owning side to null (unless already changed)
            if ($mouvement->getDeliveryMemberCode() === $this) {
                $mouvement->setDeliveryMemberCode(null);
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
            $mouvementl->setDeliveredMemberCode($this);
        }

        return $this;
    }

    public function removeMouvementl(Mouvement $mouvementl): self
    {
        if ($this->mouvementl->removeElement($mouvementl)) {
            // set the owning side to null (unless already changed)
            if ($mouvementl->getDeliveredMemberCode() === $this) {
                $mouvementl->setDeliveredMemberCode(null);
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
            $stock->setMembershipCode($this);
        }

        return $this;
    }

    public function removeStock(Stock $stock): self
    {
        if ($this->stocks->removeElement($stock)) {
            // set the owning side to null (unless already changed)
            if ($stock->getMembershipCode() === $this) {
                $stock->setMembershipCode(null);
            }
        }

        return $this;
    }
}
