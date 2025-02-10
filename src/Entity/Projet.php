<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjetRepository::class)]
class Projet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;


    #[ORM\Column]
    private ?bool $archive = null;

    #[ORM\ManyToMany(targetEntity: Employe::class, inversedBy: 'projets')]
    private Collection $employes;

    /**
     * @var Collection<int, Tache>
     */
    #[ORM\OneToMany(targetEntity: Tache::class, mappedBy: 'projet_id', orphanRemoval: true)]
    private Collection $tache_id;

    public function __construct()
    {
        $this->employes = new ArrayCollection();
        $this->tache_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function isArchive(): ?bool
    {
        return $this->archive;
    }

    public function setArchive(bool $archive): static
    {
        $this->archive = $archive;

        return $this;
    }

    public function getEmployes(): Collection
    {
        return $this->employes;
    }

    public function addEmploye(Employe $employe): static
    {
        if (!$this->employes->contains($employe)) {
            $this->employes->add($employe);
            $employe->addProjet($this);
        }

        return $this;
    }
    public function setEmploye(Employe $employe): static
    {
        if (!$this->employes->contains($employe)) {
            $this->employes->add($employe);
            $employe->addProjet($this);
        }

        return $this;
    }


    public function removeEmploye(Employe $employe): static
    {
        if ($this->employes->removeElement($employe)) {
            $employe->removeProjet($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Tache>
     */
    public function getTacheId(): Collection
    {
        return $this->tache_id;
    }

    public function addTacheId(Tache $tacheId): static
    {
        if (!$this->tache_id->contains($tacheId)) {
            $this->tache_id->add($tacheId);
        }

        return $this;
    }

    public function removeTacheId(Tache $tacheId): static
    {
        if ($this->tache_id->removeElement($tacheId)) {
            // set the owning side to null (unless already changed)
            if ($tacheId->getProjet() === $this) {
            }
        }

        return $this;
    }
}
