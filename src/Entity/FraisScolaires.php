<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Repository\FraisScolairesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FraisScolairesRepository::class)]
class FraisScolaires
{
    use CreatedAtTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $fraisInscription = null;

    #[ORM\Column(nullable: true)]
    private ?int $fraisCarnet = null;

    #[ORM\Column(nullable: true)]
    private ?int $fraisTransfert = null;

    #[ORM\Column(nullable: true)]
    private ?int $septembre = null;

    #[ORM\Column]
    private ?int $octobre = null;

    #[ORM\Column]
    private ?int $novembre = null;

    #[ORM\Column]
    private ?int $decembre = null;

    #[ORM\Column]
    private ?int $janvier = null;

    #[ORM\Column]
    private ?int $fevrier = null;

    #[ORM\Column]
    private ?int $mars = null;

    #[ORM\Column]
    private ?int $avril = null;

    #[ORM\Column]
    private ?int $mai = null;

    #[ORM\Column(nullable: true)]
    private ?int $juin = null;

    #[ORM\Column(nullable: true)]
    private ?int $autres = null;

    #[ORM\ManyToOne(inversedBy: 'fraisScolaires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Niveaux $niveau = null;

    #[ORM\ManyToOne(inversedBy: 'fraisScolaires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Statuts $statut = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFraisInscription(): ?int
    {
        return $this->fraisInscription;
    }

    public function setFraisInscription(?int $fraisInscription): static
    {
        $this->fraisInscription = $fraisInscription;

        return $this;
    }

    public function getFraisCarnet(): ?int
    {
        return $this->fraisCarnet;
    }

    public function setFraisCarnet(?int $fraisCarnet): static
    {
        $this->fraisCarnet = $fraisCarnet;

        return $this;
    }

    public function getFraisTransfert(): ?int
    {
        return $this->fraisTransfert;
    }

    public function setFraisTransfert(?int $fraisTransfert): static
    {
        $this->fraisTransfert = $fraisTransfert;

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

    public function setOctobre(int $octobre): static
    {
        $this->octobre = $octobre;

        return $this;
    }

    public function getNovembre(): ?int
    {
        return $this->novembre;
    }

    public function setNovembre(int $novembre): static
    {
        $this->novembre = $novembre;

        return $this;
    }

    public function getDecembre(): ?int
    {
        return $this->decembre;
    }

    public function setDecembre(int $decembre): static
    {
        $this->decembre = $decembre;

        return $this;
    }

    public function getJanvier(): ?int
    {
        return $this->janvier;
    }

    public function setJanvier(int $janvier): static
    {
        $this->janvier = $janvier;

        return $this;
    }

    public function getFevrier(): ?int
    {
        return $this->fevrier;
    }

    public function setFevrier(int $fevrier): static
    {
        $this->fevrier = $fevrier;

        return $this;
    }

    public function getMars(): ?int
    {
        return $this->mars;
    }

    public function setMars(int $mars): static
    {
        $this->mars = $mars;

        return $this;
    }

    public function getAvril(): ?int
    {
        return $this->avril;
    }

    public function setAvril(int $avril): static
    {
        $this->avril = $avril;

        return $this;
    }

    public function getMai(): ?int
    {
        return $this->mai;
    }

    public function setMai(int $mai): static
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

    public function getAutres(): ?int
    {
        return $this->autres;
    }

    public function setAutres(?int $autres): static
    {
        $this->autres = $autres;

        return $this;
    }

    public function getNiveau(): ?Niveaux
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveaux $niveau): static
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getStatut(): ?Statuts
    {
        return $this->statut;
    }

    public function setStatut(?Statuts $statut): static
    {
        $this->statut = $statut;

        return $this;
    }
}
