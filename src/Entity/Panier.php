<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'panier', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: Chaussure::class, inversedBy: 'paniers')]
    private Collection $chaussure;

    public function __construct()
    {
        $this->chaussure = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

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
