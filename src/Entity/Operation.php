<?php

namespace App\Entity;

use App\Repository\OperationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OperationRepository::class)
 */
class Operation
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $OperationCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $OperationLabel;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $UpdateDate;

    /**
     * @ORM\OneToMany(targetEntity="Mouvement",mappedBy="OperationCode")
     * @ORM\JoinColumn(name="mouvement_id", referencedColumnName="id")
     */
    private $Mouvements;

    public function __construct()
    {
        $this->Mouvements = new ArrayCollection();
    }

    public function getOperationCode(): ?string
    {
        return $this->OperationCode;
    }

    public function setOperationCode(?string $OperationCode): self
    {
        $this->OperationCode = $OperationCode;

        return $this;
    }

    public function getOperationLabel(): ?string
    {
        return $this->OperationLabel;
    }

    public function setOperationLabel(?string $OperationLabel): self
    {
        $this->OperationLabel = $OperationLabel;

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
            $mouvement->setOperationCode($this);
        }

        return $this;
    }

    public function removeMouvement(Mouvement $mouvement): self
    {
        if ($this->Mouvements->removeElement($mouvement)) {
            // set the owning side to null (unless already changed)
            if ($mouvement->getOperationCode() === $this) {
                $mouvement->setOperationCode(null);
            }
        }

        return $this;
    }
}
