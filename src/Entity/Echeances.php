<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Repository\EcheancesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EcheancesRepository::class)]
class Echeances
{
    use CreatedAtTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $echeance = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEcheance(): ?\DateTimeInterface
    {
        return $this->echeance;
    }

    public function setEcheance(\DateTimeInterface $echeance): static
    {
        $this->echeance = $echeance;

        return $this;
    }
}
