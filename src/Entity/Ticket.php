<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $ticket_date = null;

    #[ORM\Column(length: 255)]
    private ?string $ticket_firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $ticket_lastname = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $ticket_time = null;

    #[ORM\Column(length: 255)]
    private ?string $ticket_place = null;

    #[ORM\Column(length: 255)]
    private ?string $ticket_nuber_place = null;

    #[ORM\ManyToOne(inversedBy: 'relation')]
    private ?Programmation $programmation_ticket = null;

    #[ORM\ManyToOne(inversedBy: 'relation')]
    private ?User $user_ticket = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getTicketDate(): ?\DateTimeInterface
    {
        return $this->ticket_date;
    }

    public function setTicketDate(\DateTimeInterface $ticket_date): static
    {
        $this->ticket_date = $ticket_date;

        return $this;
    }

    public function getTicketFirstname(): ?string
    {
        return $this->ticket_firstname;
    }

    public function setTicketFirstname(string $ticket_firstname): static
    {
        $this->ticket_firstname = $ticket_firstname;

        return $this;
    }

    public function getTicketLastname(): ?string
    {
        return $this->ticket_lastname;
    }

    public function setTicketLastname(string $ticket_lastname): static
    {
        $this->ticket_lastname = $ticket_lastname;

        return $this;
    }

    public function getTicketTime(): ?\DateTimeInterface
    {
        return $this->ticket_time;
    }

    public function setTicketTime(\DateTimeInterface $ticket_time): static
    {
        $this->ticket_time = $ticket_time;

        return $this;
    }

    public function getTicketPlace(): ?string
    {
        return $this->ticket_place;
    }

    public function setTicketPlace(string $ticket_place): static
    {
        $this->ticket_place = $ticket_place;

        return $this;
    }

    public function getTicketNuberPlace(): ?string
    {
        return $this->ticket_nuber_place;
    }

    public function setTicketNuberPlace(string $ticket_nuber_place): static
    {
        $this->ticket_nuber_place = $ticket_nuber_place;

        return $this;
    }

    public function getProgrammationTicket(): ?Programmation
    {
        return $this->programmation_ticket;
    }

    public function setProgrammationTicket(?Programmation $programmation_ticket): static
    {
        $this->programmation_ticket = $programmation_ticket;

        return $this;
    }

    public function getUserTicket(): ?User
    {
        return $this->user_ticket;
    }

    public function setUserTicket(?User $user_ticket): static
    {
        $this->user_ticket = $user_ticket;

        return $this;
    }
}
