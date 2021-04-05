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
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=2, unique=true)
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
     * @ORM\OneToMany(targetEntity=Mouvement::class, mappedBy="OperationCode")
     */
    private $mouvements;

    public function __construct()
    {
        $this->mouvements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOperationCode(): ?string
    {
        return $this->OperationCode;
    }

    public function setOperationCode(string $OperationCode): self
    {
        $this->OperationCode = $OperationCode;

        return $this;
    }

    public function getOperationLabel(): ?string
    {
        return $this->OperationLabel;
    }

    public function setOperationLabel(string $OperationLabel): self
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
        return $this->mouvements;
    }

    public function addMouvement(Mouvement $mouvement): self
    {
        if (!$this->mouvements->contains($mouvement)) {
            $this->mouvements[] = $mouvement;
            $mouvement->setOperationCode($this);
        }

        return $this;
    }

    public function removeMouvement(Mouvement $mouvement): self
    {
        if ($this->mouvements->removeElement($mouvement)) {
            // set the owning side to null (unless already changed)
            if ($mouvement->getOperationCode() === $this) {
                $mouvement->setOperationCode(null);
            }
        }

        return $this;
    }
}
