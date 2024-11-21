<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
class SuperHero
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $alterEgo;

    #[ORM\Column(type: 'boolean')]
    private $isAvailable;

    #[ORM\Column(type: 'integer')]
    private $energyLevel;

    #[ORM\Column(type: 'text')]
    private $biography;

    #[ORM\Column(type: 'text')]
    private $disability;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $imageName;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    #[ORM\OneToMany(targetEntity: Team::class, mappedBy: 'leader')]
    private $leadingTeams;

    #[ORM\ManyToMany(targetEntity: Team::class, mappedBy: 'members')]
    private $teams;

    public function __construct()
    {
        $this->leadingTeams = new ArrayCollection();
        $this->teams = new ArrayCollection();
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

    public function getAlterEgo(): ?string
    {
        return $this->alterEgo;
    }

    public function setAlterEgo(?string $alterEgo): self
    {
        $this->alterEgo = $alterEgo;
        return $this;
    }

    public function isIsAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): self
    {
        $this->isAvailable = $isAvailable;
        return $this;
    }

    public function getEnergyLevel(): ?int
    {
        return $this->energyLevel;
    }

    public function setEnergyLevel(int $energyLevel): self
    {
        $this->energyLevel = $energyLevel;
        return $this;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(string $biography): self
    {
        $this->biography = $biography;
        return $this;
    }

    public function getDisability(): ?string
    {
        return $this->disability;
    }

    public function setDisability(string $disability): self
    {
        $this->disability = $disability;
        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;
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

    /**
     * @return Collection|Team[]
     */
    public function getLeadingTeams(): Collection
    {
        return $this->leadingTeams;
    }

    public function addLeadingTeam(Team $team): self
    {
        if (!$this->leadingTeams->contains($team)) {
            $this->leadingTeams[] = $team;
            $team->setLeader($this);
        }
        return $this;
    }

    public function removeLeadingTeam(Team $team): self
    {
        if ($this->leadingTeams->removeElement($team)) {
            // set the owning side to null (unless already changed)
            if ($team->getLeader() === $this) {
                $team->setLeader(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|Team[]
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
            $team->addMember($this);
        }
        return $this;
    }

    public function removeTeam(Team $team): self
    {
        if ($this->teams->removeElement($team)) {
            $team->removeMember($this);
        }
        return $this;
    }
}
