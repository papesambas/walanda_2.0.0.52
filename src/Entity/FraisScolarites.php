<?php

namespace App\Entity;

use App\Repository\FraisScolaritesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FraisScolaritesRepository::class)]
class FraisScolarites
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'fraisScolarites')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Eleves $eleve = null;

    #[ORM\ManyToOne(inversedBy: 'fraisScolarites')]
    private ?FraisType $fraisType = null;

    #[ORM\Column]
    private ?int $montant = 0;

    #[ORM\ManyToOne(inversedBy: 'fraisScolarites')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FraisScolaires $fraisScolaires = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEleve(): ?Eleves
    {
        return $this->eleve;
    }

    public function setEleve(?Eleves $eleve): static
    {
        $this->eleve = $eleve;

        return $this;
    }

    public function getFraisType(): ?FraisType
    {
        return $this->fraisType;
    }

    public function setFraisType(?FraisType $fraisType): static
    {
        $this->fraisType = $fraisType;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getFraisScolaires(): ?FraisScolaires
    {
        return $this->fraisScolaires;
    }

    public function setFraisScolaires(?FraisScolaires $fraisScolaires): static
    {
        $this->fraisScolaires = $fraisScolaires;

        return $this;
    }
}