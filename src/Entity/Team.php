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

    #[ORM\OneToMany(mappedBy: 'assignedTeam', targetEntity: Mission::class)]
    private $missions;

    public function __construct()
    {
        $this->members = new ArrayCollection();
        $this->missions = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->isActive = true;
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

    public function isActive(): ?bool
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
            $member->addTeam($this);
        }
        return $this;
    }

    public function removeMember(SuperHero $member): self
    {
        if ($this->members->removeElement($member)) {
            $member->removeTeam($this);
        }
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

    /**
     * @return Collection|Mission[]
     */
    public function getMissions(): Collection
    {
        return $this->missions;
    }

    public function addMission(Mission $mission): self
    {
        if (!$this->missions->contains($mission)) {
            $this->missions[] = $mission;
            $mission->setAssignedTeam($this);
        }
        return $this;
    }

    public function removeMission(Mission $mission): self
    {
        if ($this->missions->removeElement($mission)) {
            if ($mission->getAssignedTeam() === $this) {
                $mission->setAssignedTeam(null);
            }
        }
        return $this;
    }
}
