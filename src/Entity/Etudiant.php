<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EtudiantRepository")
 */
class Etudiant
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
     * @ORM\Column(type="string", length=50, nullable=true)
     *
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "La ville doit comporter au moins 2 caractères",
     *      maxMessage = "La ville doit comporter au plus 50 caractères"
     *    )
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $copos;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     *
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le code postal doit comporter 5 caractères",
     *      maxMessage = "Le code postal doit comporter 5 caractères"
     *    )
     */
    private $rue;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     *
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "La rue doit comporter au moins 2 caractères",
     *      maxMessage = "La rue doit comporter au plus 50 caractères"
     *    )
     */
    private $surnom;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numrue;

    /**
     * @ORM\Column(type="string", length=1, nullable=true)
     *
     * @Assert\Length(
     *      min = 1,
     *      max = 1,
     *      minMessage = "Le sexe doit comporter 1 caractère",
     *      maxMessage = "Le sexe doit comporter 1 caractère"
     *    )
     * @Assert\NotBlank()
     */
    private $Sexe;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Maison", inversedBy="etudiants")
     */
    private $maison;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Note", mappedBy="etudiant")
     */
    private $notes;

    public function __construct()
    {
        $this->notes = new ArrayCollection();
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

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

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

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(?string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    public function getSurnom(): ?string
    {
        return $this->surnom;
    }

    public function setSurnom(?string $surnom): self
    {
        $this->surnom = $surnom;

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

    public function getSexe(): ?string
    {
        return $this->Sexe;
    }

    public function setSexe(?string $Sexe): self
    {
        $this->Sexe = $Sexe;

        return $this;
    }

    public function getMaison(): ?Maison
    {
        return $this->maison;
    }

    public function setMaison(?Maison $maison): self
    {
        $this->maison = $maison;

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
            $note->setEtudiant($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->contains($note)) {
            $this->notes->removeElement($note);
            // set the owning side to null (unless already changed)
            if ($note->getEtudiant() === $this) {
                $note->setEtudiant(null);
            }
        }

        return $this;
    }
}
