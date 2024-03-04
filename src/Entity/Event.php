<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $event_name = null;

    #[ORM\Column(length: 255)]
    private ?string $event_place = null;

    #[ORM\Column(length: 255)]
    private ?string $organisation_name = null;

    #[ORM\Column(length: 255)]
    private ?string $event_image = null;

    #[ORM\ManyToOne(inversedBy: 'relation')]
    private ?Category $category_event = null;

    #[ORM\OneToMany(targetEntity: Programmation::class, mappedBy: 'event_programmation')]
    private Collection $relation;

    public function __construct()
    {
        $this->relation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEventName(): ?string
    {
        return $this->event_name;
    }

    public function setEventName(string $event_name): static
    {
        $this->event_name = $event_name;

        return $this;
    }

    public function getEventPlace(): ?string
    {
        return $this->event_place;
    }

    public function setEventPlace(string $event_place): static
    {
        $this->event_place = $event_place;

        return $this;
    }

    public function getOrganisationName(): ?string
    {
        return $this->organisation_name;
    }

    public function setOrganisationName(string $organisation_name): static
    {
        $this->organisation_name = $organisation_name;

        return $this;
    }

    public function getEventImage(): ?string
    {
        return $this->event_image;
    }

    public function setEventImage(string $event_image): static
    {
        $this->event_image = $event_image;

        return $this;
    }

    public function getCategoryEvent(): ?Category
    {
        return $this->category_event;
    }

    public function setCategoryEvent(?Category $category_event): static
    {
        $this->category_event = $category_event;

        return $this;
    }

    /**
     * @return Collection<int, Programmation>
     */
    public function getRelation(): Collection
    {
        return $this->relation;
    }

    public function addRelation(Programmation $relation): static
    {
        if (!$this->relation->contains($relation)) {
            $this->relation->add($relation);
            $relation->setEventProgrammation($this);
        }

        return $this;
    }

    public function removeRelation(Programmation $relation): static
    {
        if ($this->relation->removeElement($relation)) {
            // set the owning side to null (unless already changed)
            if ($relation->getEventProgrammation() === $this) {
                $relation->setEventProgrammation(null);
            }
        }

        return $this;
    }
}
