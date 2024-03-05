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
    private ?Category $category = null;

    #[ORM\OneToMany(targetEntity: Programmation::class, mappedBy: 'event')]
    private Collection $relation;

    #[ORM\Column]
    private ?float $event_price = null;

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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

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
            $relation->setEvent($this);
        }

        return $this;
    }

    public function removeRelation(Programmation $relation): static
    {
        if ($this->relation->removeElement($relation)) {
            // set the owning side to null (unless already changed)
            if ($relation->getEvent() === $this) {
                $relation->setEvent(null);
            }
        }

        return $this;
    }

    public function getEventPrice(): ?float
    {
        return $this->event_price;
    }

    public function setEventPrice(float $event_price): static
    {
        $this->event_price = $event_price;

        return $this;
    }
}
