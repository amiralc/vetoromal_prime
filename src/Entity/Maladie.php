<?php

namespace App\Entity;

use App\Repository\MaladieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaladieRepository::class)]
class Maladie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $type_aniaml = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_creation = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_MAJ = null;

    #[ORM\OneToMany(mappedBy: 'maladie', targetEntity: Operation::class)]
    private Collection $Operation;

    public function __toString()
    {
        return $this->nom;
    }


    public function __construct()
    {
        $this->Operation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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

    public function getTypeAniaml(): ?string
    {
        return $this->type_aniaml;
    }

    public function setTypeAniaml(string $type_aniaml): self
    {
        $this->type_aniaml = $type_aniaml;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getDateMAJ(): ?\DateTimeInterface
    {
        return $this->date_MAJ;
    }

    public function setDateMAJ(\DateTimeInterface $date_MAJ): self
    {
        $this->date_MAJ = $date_MAJ;

        return $this;
    }

    /**
     * @return Collection<int, Operation>
     */
    public function getOperation(): Collection
    {
        return $this->Operation;
    }

    public function addOperation(Operation $operation): self
    {
        if (!$this->Operation->contains($operation)) {
            $this->Operation->add($operation);
            $operation->setMaladie($this);
        }

        return $this;
    }

    public function removeOperation(Operation $operation): self
    {
        if ($this->Operation->removeElement($operation)) {
            // set the owning side to null (unless already changed)
            if ($operation->getMaladie() === $this) {
                $operation->setMaladie(null);
            }
        }

        return $this;
    }

   
}
