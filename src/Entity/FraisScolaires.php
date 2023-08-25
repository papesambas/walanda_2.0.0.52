<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Repository\FraisScolairesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FraisScolairesRepository::class)]
class FraisScolaires
{
    use CreatedAtTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $designation = null;

    #[ORM\Column]
    private ?int $montant = null;

    #[ORM\ManyToOne(inversedBy: 'fraisScolaires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Echeances $echeance = null;

    #[ORM\ManyToOne(inversedBy: 'fraisScolaires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FraisType $fraisType = null;

    #[ORM\OneToMany(mappedBy: 'fraisScolaires', targetEntity: FraisScolarites::class)]
    private Collection $fraisScolarites;

    public function __construct()
    {
        $this->fraisScolarites = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): static
    {
        $this->designation = $designation;

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

    public function getEcheance(): ?Echeances
    {
        return $this->echeance;
    }

    public function setEcheance(?Echeances $echeance): static
    {
        $this->echeance = $echeance;

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

    /**
     * @return Collection<int, FraisScolarites>
     */
    public function getFraisScolarites(): Collection
    {
        return $this->fraisScolarites;
    }

    public function addFraisScolarite(FraisScolarites $fraisScolarite): static
    {
        if (!$this->fraisScolarites->contains($fraisScolarite)) {
            $this->fraisScolarites->add($fraisScolarite);
            $fraisScolarite->setFraisScolaires($this);
        }

        return $this;
    }

    public function removeFraisScolarite(FraisScolarites $fraisScolarite): static
    {
        if ($this->fraisScolarites->removeElement($fraisScolarite)) {
            // set the owning side to null (unless already changed)
            if ($fraisScolarite->getFraisScolaires() === $this) {
                $fraisScolarite->setFraisScolaires(null);
            }
        }

        return $this;
    }
}
