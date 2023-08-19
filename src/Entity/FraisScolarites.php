<?php

namespace App\Entity;

use App\Repository\FraisScolaritesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FraisScolaritesRepository::class)]
#[UniqueEntity(fields: ['eleve'], message: 'There is already an account with this eleve')]

class FraisScolarites
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'fraisScolarites', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'eleve_id', referencedColumnName: 'id', unique: true)]
    private ?Eleves $eleve = null;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero]
    private ?int $inscription = null;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero]
    private ?int $carnet = null;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero]
    private ?int $transfert = null;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero]
    private ?int $septembre = null;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero]
    private ?int $octobre = null;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero]
    private ?int $novembre = null;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero]
    private ?int $decembre = null;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero]
    private ?int $janvier = null;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero]
    private ?int $fevrier = null;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero]
    private ?int $mars = null;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero]
    private ?int $avril = null;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero]
    private ?int $mai = null;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero]
    private ?int $juin = null;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero]
    private ?int $autre = null;

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

    public function getInscription(): ?int
    {
        return $this->inscription;
    }

    public function setInscription(?int $inscription): static
    {
        $this->inscription = $inscription;

        return $this;
    }

    public function getCarnet(): ?int
    {
        return $this->carnet;
    }

    public function setCarnet(?int $carnet): static
    {
        $this->carnet = $carnet;

        return $this;
    }

    public function getTransfert(): ?int
    {
        return $this->transfert;
    }

    public function setTransfert(?int $transfert): static
    {
        $this->transfert = $transfert;

        return $this;
    }

    public function getSeptembre(): ?int
    {
        return $this->septembre;
    }

    public function setSeptembre(?int $septembre): static
    {
        $this->septembre = $septembre;

        return $this;
    }

    public function getOctobre(): ?int
    {
        return $this->octobre;
    }

    public function setOctobre(?int $octobre): static
    {
        $this->octobre = $octobre;

        return $this;
    }

    public function getNovembre(): ?int
    {
        return $this->novembre;
    }

    public function setNovembre(?int $novembre): static
    {
        $this->novembre = $novembre;

        return $this;
    }

    public function getDecembre(): ?int
    {
        return $this->decembre;
    }

    public function setDecembre(?int $decembre): static
    {
        $this->decembre = $decembre;

        return $this;
    }

    public function getJanvier(): ?int
    {
        return $this->janvier;
    }

    public function setJanvier(?int $janvier): static
    {
        $this->janvier = $janvier;

        return $this;
    }

    public function getFevrier(): ?int
    {
        return $this->fevrier;
    }

    public function setFevrier(?int $fevrier): static
    {
        $this->fevrier = $fevrier;

        return $this;
    }

    public function getMars(): ?int
    {
        return $this->mars;
    }

    public function setMars(?int $mars): static
    {
        $this->mars = $mars;

        return $this;
    }

    public function getAvril(): ?int
    {
        return $this->avril;
    }

    public function setAvril(?int $avril): static
    {
        $this->avril = $avril;

        return $this;
    }

    public function getMai(): ?int
    {
        return $this->mai;
    }

    public function setMai(?int $mai): static
    {
        $this->mai = $mai;

        return $this;
    }

    public function getJuin(): ?int
    {
        return $this->juin;
    }

    public function setJuin(?int $juin): static
    {
        $this->juin = $juin;

        return $this;
    }

    public function getAutre(): ?int
    {
        return $this->autre;
    }

    public function setAutre(?int $autre): static
    {
        $this->autre = $autre;

        return $this;
    }
}