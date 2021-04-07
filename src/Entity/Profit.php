<?php

namespace App\Entity;

use App\Repository\ProfitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfitRepository::class)
 */
class Profit
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
    private $ProfitCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ProfitLabel;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $UpdateDate;

    /**
     * @ORM\OneToMany(targetEntity=Intermediaire::class, mappedBy="Profit")
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

    public function getProfitCode(): ?string
    {
        return $this->ProfitCode;
    }

    public function setProfitCode(string $ProfitCode): self
    {
        $this->ProfitCode = $ProfitCode;

        return $this;
    }

    public function getProfitLabel(): ?string
    {
        return $this->ProfitLabel;
    }

    public function setProfitLabel(?string $ProfitLabel): self
    {
        $this->ProfitLabel = $ProfitLabel;

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
            $intermediaire->setProfit($this);
        }

        return $this;
    }

    public function removeIntermediaire(Intermediaire $intermediaire): self
    {
        if ($this->intermediaires->removeElement($intermediaire)) {
            // set the owning side to null (unless already changed)
            if ($intermediaire->getProfit() === $this) {
                $intermediaire->setProfit(null);
            }
        }

        return $this;
    }
}
