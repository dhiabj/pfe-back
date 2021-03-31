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
     * @ORM\Column(type="string", length=255)
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
     * @ORM\OneToMany(targetEntity="Member",mappedBy="MemberTypeCode")
     * @ORM\JoinColumn(name="member_id", referencedColumnName="id")
     */
    private $Members;

    public function __construct()
    {
        $this->Members = new ArrayCollection();
    }

    public function getMemberTypeCode(): ?string
    {
        return $this->MemberTypeCode;
    }

    public function getMemberTypeLabel(): ?string
    {
        return $this->MemberTypeLabel;
    }

    public function setMemberTypeLabel(?string $MemberTypeLabel): self
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
    public function getMembers(): Collection
    {
        return $this->Members;
    }

    public function addMember(Member $member): self
    {
        if (!$this->Members->contains($member)) {
            $this->Members[] = $member;
            $member->setMemberTypeCode($this);
        }

        return $this;
    }

    public function removeMember(Member $member): self
    {
        if ($this->Members->removeElement($member)) {
            // set the owning side to null (unless already changed)
            if ($member->getMemberTypeCode() === $this) {
                $member->setMemberTypeCode(null);
            }
        }

        return $this;
    }
}
