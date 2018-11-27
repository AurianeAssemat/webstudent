<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompetenceRepository")
 */
class Competence
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=3)
      *
     * @Assert\Length(
     *      min = 3,
     *      max = 3,
     *      minMessage = "Le code doit comporter 3 caractères",
     *      maxMessage = "Le code doit comporter  3 caractères"
     *    )
     * @Assert\NotBlank()
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
      *
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le libelle doit comporter au moins 2 caractères",
     *      maxMessage = "Le libelle doit comporter au plus 50 caractères"
     *    )
     * @Assert\NotBlank()
     */
    private $libelle;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nb_etudiants_max;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Professeur", inversedBy="competences")
     */
    private $professeurs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Note", mappedBy="competence")
     */
    private $notes;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Stage", mappedBy="competences")
     */
    private $stages;

    public function __construct()
    {
        $this->professeurs = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->stages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getNbEtudiantsMax(): ?int
    {
        return $this->nb_etudiants_max;
    }

    public function setNbEtudiantsMax(?int $nb_etudiants_max): self
    {
        $this->nb_etudiants_max = $nb_etudiants_max;

        return $this;
    }

    /**
     * @return Collection|Professeur[]
     */
    public function getProfesseurs(): Collection
    {
        return $this->professeurs;
    }

    public function addProfesseur(Professeur $professeur): self
    {
        if (!$this->professeurs->contains($professeur)) {
            $this->professeurs[] = $professeur;
        }

        return $this;
    }

    public function removeProfesseur(Professeur $professeur): self
    {
        if ($this->professeurs->contains($professeur)) {
            $this->professeurs->removeElement($professeur);
        }

        return $this;
    }

    /**
     * @return Collection|Note[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setCompetence($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->contains($note)) {
            $this->notes->removeElement($note);
            // set the owning side to null (unless already changed)
            if ($note->getCompetence() === $this) {
                $note->setCompetence(null);
            }
        }

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
            $stage->addCompetence($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->stages->contains($stage)) {
            $this->stages->removeElement($stage);
            $stage->removeCompetence($this);
        }

        return $this;
    }
}
