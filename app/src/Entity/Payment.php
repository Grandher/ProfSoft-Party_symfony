<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentRepository::class)]
class Payment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?float $amount = null;

    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'payments')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Guest $guestDeclared = null;

    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'payments')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Guest $guestReceived = null;

    #[ORM\ManyToOne(inversedBy: 'payments')]
    private ?User $author = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getGuestDeclared(): ?Guest
    {
        return $this->guestDeclared;
    }

    public function setGuestDeclared(?Guest $guestDeclared): static
    {
        $this->guestDeclared = $guestDeclared;

        return $this;
    }

    public function getGuestReceived(): ?Guest
    {
        return $this->guestReceived;
    }

    public function setGuestReceived(?Guest $guestReceived): static
    {
        $this->guestReceived = $guestReceived;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }
}
