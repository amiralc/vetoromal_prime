<?php

namespace App\Entity;

use App\Repository\RendezVousRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RendezVousRepository::class)]
class RendezVous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"date is required")]
    private ?string $date = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank("dure is required")]
    private ?string $duree = null;

    #[ORM\ManyToOne(inversedBy: 'rendezVouses')]
    private ?Animal $animal = null;

    #[ORM\OneToOne(mappedBy: 'rendezvous', cascade: ['persist', 'remove'])]
    private ?Ordonnance $ordonnance = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): self
    {
        $this->animal = $animal;

        return $this;
    }

    public function getOrdonnance(): ?Ordonnance
    {
        return $this->ordonnance;
    }

    public function setOrdonnance(?Ordonnance $ordonnance): self
    {
        // unset the owning side of the relation if necessary
        if ($ordonnance === null && $this->ordonnance !== null) {
            $this->ordonnance->setRendezvous(null);
        }

        // set the owning side of the relation if necessary
        if ($ordonnance !== null && $ordonnance->getRendezvous() !== $this) {
            $ordonnance->setRendezvous($this);
        }

        $this->ordonnance = $ordonnance;

        return $this;
    }
}
