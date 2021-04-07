<?php

namespace App\Entity;

use App\Repository\ReglementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReglementRepository::class)
 */
class Reglement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1, unique=true)
     */
    private $ReglementCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ReglementLabel;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $UpdateDate;

    /**
     * @ORM\OneToMany(targetEntity=Intermediaire::class, mappedBy="Reglement")
     */
    private $intermediaires;

    public function __construct()
    {
        $this->intermediaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReglementCode(): ?string
    {
        return $this->ReglementCode;
    }

    public function setReglementCode(string $ReglementCode): self
    {
        $this->ReglementCode = $ReglementCode;

        return $this;
    }

    public function getReglementLabel(): ?string
    {
        return $this->ReglementLabel;
    }

    public function setReglementLabel(?string $ReglementLabel): self
    {
        $this->ReglementLabel = $ReglementLabel;

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
     * @return Collection|Intermediaire[]
     */
    public function getIntermediaires(): Collection
    {
        return $this->intermediaires;
    }

    public function addIntermediaire(Intermediaire $intermediaire): self
    {
        if (!$this->intermediaires->contains($intermediaire)) {
            $this->intermediaires[] = $intermediaire;
            $intermediaire->setReglement($this);
        }

        return $this;
    }

    public function removeIntermediaire(Intermediaire $intermediaire): self
    {
        if ($this->intermediaires->removeElement($intermediaire)) {
            // set the owning side to null (unless already changed)
            if ($intermediaire->getReglement() === $this) {
                $intermediaire->setReglement(null);
            }
        }

        return $this;
    }
}
