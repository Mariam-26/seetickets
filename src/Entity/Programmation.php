<?php

namespace App\Entity;

use App\Repository\ProgrammationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProgrammationRepository::class)]
class Programmation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $programmation_date = null;

    #[ORM\ManyToOne(inversedBy: 'relation')]
    private ?Event $event = null;

    #[ORM\OneToMany(targetEntity: Ticket::class, mappedBy: 'programmation')]
    private Collection $relation;

    public function __construct()
    {
        $this->relation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProgrammationDate(): ?\DateTimeInterface
    {
        return $this->programmation_date;
    }

    public function setProgrammationDate(\DateTimeInterface $programmation_date): static
    {
        $this->programmation_date = $programmation_date;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): static
    {
        $this->event = $event;

        return $this;
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getRelation(): Collection
    {
        return $this->relation;
    }

    public function addRelation(Ticket $relation): static
    {
        if (!$this->relation->contains($relation)) {
            $this->relation->add($relation);
            $relation->setProgrammation($this);
        }

        return $this;
    }

    public function removeRelation(Ticket $relation): static
    {
        if ($this->relation->removeElement($relation)) {
            // set the owning side to null (unless already changed)
            if ($relation->getProgrammation() === $this) {
                $relation->setProgrammation(null);
            }
        }

        return $this;
    }
}
