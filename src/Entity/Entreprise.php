<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EntrepriseRepository")
 */
class Entreprise
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numrue;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $rue;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $copos;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $ville;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Stage", mappedBy="entreprise")
     */
    private $stages;

    public function __construct()
    {
        $this->stages = new ArrayCollection();
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

    public function getNumrue(): ?int
    {
        return $this->numrue;
    }

    public function setNumrue(?int $numrue): self
    {
        $this->numrue = $numrue;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(?string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    public function getCopos(): ?string
    {
        return $this->copos;
    }

    public function setCopos(?string $copos): self
    {
        $this->copos = $copos;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * @return Collection|Stage[]
     */
    public function getStages(): Collection
    {
        return $this->stages;
    }

    public function addStage(Stage $stage): self
    {
        if (!$this->stages->contains($stage)) {
            $this->stages[] = $stage;
            $stage->setEntreprise($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->stages->contains($stage)) {
            $this->stages->removeElement($stage);
            // set the owning side to null (unless already changed)
            if ($stage->getEntreprise() === $this) {
                $stage->setEntreprise(null);
            }
        }

        return $this;
    }
}
