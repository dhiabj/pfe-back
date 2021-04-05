<?php

namespace App\Entity;

use App\Repository\MemberTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MemberTypeRepository::class)
 */
class MemberType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $MemberTypeCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $MemberTypeLabel;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $UpdateDate;

    /**
     * @ORM\OneToMany(targetEntity=Member::class, mappedBy="MemberType", orphanRemoval=true)
     */
    private $members;

    public function __construct()
    {
        $this->members = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMemberTypeCode(): ?string
    {
        return $this->MemberTypeCode;
    }

    public function setMemberTypeCode(string $MemberTypeCode): self
    {
        $this->MemberTypeCode = $MemberTypeCode;

        return $this;
    }

    public function getMemberTypeLabel(): ?string
    {
        return $this->MemberTypeLabel;
    }

    public function setMemberTypeLabel(string $MemberTypeLabel): self
    {
        $this->MemberTypeLabel = $MemberTypeLabel;

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
     * @return Collection|Member[]
     */
    public function getmembers(): Collection
    {
        return $this->members;
    }

    public function addMember(Member $Member): self
    {
        if (!$this->members->contains($Member)) {
            $this->members[] = $Member;
            $Member->setMemberType($this);
        }

        return $this;
    }

    public function removeMember(Member $Member): self
    {
        if ($this->members->removeElement($Member)) {
            // set the owning side to null (unless already changed)
            if ($Member->getMemberType() === $this) {
                $Member->setMemberType(null);
            }
        }

        return $this;
    }
}
