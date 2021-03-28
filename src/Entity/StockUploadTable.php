<?php

namespace App\Entity;

use App\Repository\StockUploadTableRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StockUploadTableRepository::class)
 */
class StockUploadTable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $FileName;

    /**
     * @ORM\Column(type="datetime")
     */
    private $UploadDate;

    /**
     * @ORM\Column(type="date")
     */
    private $StockExchangeDate;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $StateFile;

    /**
     * @ORM\Column(type="integer")
     */
    private $NbLines;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFileName(): ?string
    {
        return $this->FileName;
    }

    public function setFileName(string $FileName): self
    {
        $this->FileName = $FileName;

        return $this;
    }

    public function getStockExchangeDate(): ?\DateTimeInterface
    {
        return $this->StockExchangeDate;
    }

    public function setStockExchangeDate(\DateTimeInterface $StockExchangeDate): self
    {
        $this->StockExchangeDate = $StockExchangeDate;

        return $this;
    }

    public function getStateFile(): ?string
    {
        return $this->StateFile;
    }

    public function setStateFile(string $StateFile): self
    {
        $this->StateFile = $StateFile;

        return $this;
    }

    public function getNbLines(): ?int
    {
        return $this->NbLines;
    }

    public function setNbLines(int $NbLines): self
    {
        $this->NbLines = $NbLines;

        return $this;
    }

    public function getUploadDate(): ?\DateTimeInterface
    {
        return $this->UploadDate;
    }

    public function setUploadDate(\DateTimeInterface $UploadDate): self
    {
        $this->UploadDate = $UploadDate;

        return $this;
    }
}
