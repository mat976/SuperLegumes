<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Mission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'string', length: 20)]
    private $status;

    #[ORM\Column(type: 'datetime')]
    private $startAt;

    #[ORM\Column(type: 'datetime')]
    private $endAt;

    #[ORM\Column(type: 'string', length: 255)]
    private $location;

    #[ORM\Column(type: 'integer')]
    private $dangerLevel;

    #[ORM\OneToOne(targetEntity: Team::class, mappedBy: 'currentMission')]
    private $assignedTeam;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;
        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;
        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;
        return $this;
    }

    public function getDangerLevel(): ?int
    {
        return $this->dangerLevel;
    }

    public function setDangerLevel(int $dangerLevel): self
    {
        $this->dangerLevel = $dangerLevel;
        return $this;
    }

    public function getAssignedTeam(): ?Team
    {
        return $this->assignedTeam;
    }

    public function setAssignedTeam(?Team $assignedTeam): self
    {
        $this->assignedTeam = $assignedTeam;
        return $this;
    }
}
