<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'boolean')]
    private $isActive;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    #[ORM\ManyToOne(targetEntity: SuperHero::class, inversedBy: 'leadingTeams')]
    #[ORM\JoinColumn(nullable: false)]
    private $leader;

    #[ORM\ManyToMany(targetEntity: SuperHero::class, inversedBy: 'teams')]
    private $members;

    #[ORM\OneToOne(targetEntity: Mission::class, inversedBy: 'assignedTeam')]
    private $currentMission;

    public function __construct()
    {
        $this->members = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getLeader(): ?SuperHero
    {
        return $this->leader;
    }

    public function setLeader(?SuperHero $leader): self
    {
        $this->leader = $leader;
        return $this;
    }

    /**
     * @return Collection|SuperHero[]
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(SuperHero $member): self
    {
        if (!$this->members->contains($member)) {
            $this->members[] = $member;
        }
        return $this;
    }

    public function removeMember(SuperHero $member): self
    {
        $this->members->removeElement($member);
        return $this;
    }

    public function getCurrentMission(): ?Mission
    {
        return $this->currentMission;
    }

    public function setCurrentMission(?Mission $currentMission): self
    {
        $this->currentMission = $currentMission;
        return $this;
    }
}
