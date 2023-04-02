<?php

namespace App\Entity;

use App\Repository\FiltreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FiltreRepository::class)]
class Filtre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToMany(targetEntity: Chaussure::class, inversedBy: 'filtres')]
    private Collection $chaussure;

    public function __construct()
    {
        $this->chaussure = new ArrayCollection();
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

    /**
     * @return Collection<int, Chaussure>
     */
    public function getChaussure(): Collection
    {
        return $this->chaussure;
    }

    public function addChaussure(Chaussure $chaussure): self
    {
        if (!$this->chaussure->contains($chaussure)) {
            $this->chaussure->add($chaussure);
        }

        return $this;
    }

    public function removeChaussure(Chaussure $chaussure): self
    {
        $this->chaussure->removeElement($chaussure);

        return $this;
    }
}
