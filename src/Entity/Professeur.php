<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfesseurRepository")
 */
class Professeur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     *
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le nom doit comporter au moins 2 caractères",
     *      maxMessage = "Le nom doit comporter au plus 50 caractères"
     *    )
     * @Assert\NotBlank()
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     *
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le prenom doit comporter au moins 2 caractères",
     *      maxMessage = "Le prenom doit comporter au plus 50 caractères"
     *    )
     * @Assert\NotBlank()
     */
    private $prenom;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dtNaissance;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Competence", mappedBy="professeurs")
     */
    private $competences;

    public function __construct()
    {
        $this->competences = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDtNaissance(): ?\DateTimeInterface
    {
        return $this->dtNaissance;
    }

    public function setDtNaissance(?\DateTimeInterface $dtNaissance): self
    {
        $this->dtNaissance = $dtNaissance;

        return $this;
    }

    /**
     * @return Collection|Competence[]
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(Competence $competence): self
    {
        if (!$this->competences->contains($competence)) {
            $this->competences[] = $competence;
            $competence->addProfesseur($this);
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): self
    {
        if ($this->competences->contains($competence)) {
            $this->competences->removeElement($competence);
            $competence->removeProfesseur($this);
        }

        return $this;
    }
}
