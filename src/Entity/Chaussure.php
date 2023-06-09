<?php

namespace App\Entity;

use App\Repository\ChaussureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChaussureRepository::class)]
class Chaussure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $prix = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\OneToMany(mappedBy: 'chaussure', targetEntity: Commentaire::class, orphanRemoval: true)]
    private Collection $commentaires;

    #[ORM\Column(length: 255)]
    private ?string $marque = null;

    #[ORM\ManyToMany(targetEntity: Panier::class, mappedBy: 'chaussure')]
    private Collection $paniers;

    #[ORM\ManyToMany(targetEntity: Filtre::class, mappedBy: 'chaussure')]
    private Collection $filtres;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->paniers = new ArrayCollection();
        $this->filtres = new ArrayCollection();
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

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setChaussure($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getChaussure() === $this) {
                $commentaire->setChaussure(null);
            }
        }

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * @return Collection<int, Panier>
     */
    public function getPaniers(): Collection
    {
        return $this->paniers;
    }

    public function addPanier(Panier $panier): self
    {
        if (!$this->paniers->contains($panier)) {
            $this->paniers->add($panier);
            $panier->addChaussure($this);
        }

        return $this;
    }

    public function removePanier(Panier $panier): self
    {
        if ($this->paniers->removeElement($panier)) {
            $panier->removeChaussure($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNom();
        return $this->getUser();
    }

    /**
     * @return Collection<int, Filtre>
     */
    public function getFiltres(): Collection
    {
        return $this->filtres;
    }

    public function addFiltre(Filtre $filtre): self
    {
        if (!$this->filtres->contains($filtre)) {
            $this->filtres->add($filtre);
            $filtre->addChaussure($this);
        }

        return $this;
    }

    public function removeFiltre(Filtre $filtre): self
    {
        if ($this->filtres->removeElement($filtre)) {
            $filtre->removeChaussure($this);
        }

        return $this;
    }
}
