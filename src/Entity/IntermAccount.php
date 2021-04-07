<?php

namespace App\Entity;

use App\Repository\IntermAccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IntermAccountRepository::class)
 */
class IntermAccount
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
    private $AccountCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $AccountLabel;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $UpdateDate;

    /**
     * @ORM\OneToMany(targetEntity=Intermediaire::class, mappedBy="AccountType")
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

    public function getAccountCode(): ?string
    {
        return $this->AccountCode;
    }

    public function setAccountCode(string $AccountCode): self
    {
        $this->AccountCode = $AccountCode;

        return $this;
    }

    public function getAccountLabel(): ?string
    {
        return $this->AccountLabel;
    }

    public function setAccountLabel(?string $AccountLabel): self
    {
        $this->AccountLabel = $AccountLabel;

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
            $intermediaire->setAccountType($this);
        }

        return $this;
    }

    public function removeIntermediaire(Intermediaire $intermediaire): self
    {
        if ($this->intermediaires->removeElement($intermediaire)) {
            // set the owning side to null (unless already changed)
            if ($intermediaire->getAccountType() === $this) {
                $intermediaire->setAccountType(null);
            }
        }

        return $this;
    }
}
