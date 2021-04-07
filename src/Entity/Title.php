<?php

namespace App\Entity;

use App\Repository\TitleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TitleRepository::class)
 */
class Title
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
    private $TitleCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $TitleLabel;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $UpdateDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleCode(): ?string
    {
        return $this->TitleCode;
    }

    public function setTitleCode(string $TitleCode): self
    {
        $this->TitleCode = $TitleCode;

        return $this;
    }

    public function getTitleLabel(): ?string
    {
        return $this->TitleLabel;
    }

    public function setTitleLabel(?string $TitleLabel): self
    {
        $this->TitleLabel = $TitleLabel;

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
}
