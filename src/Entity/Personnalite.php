<?php

namespace App\Entity;

use App\Repository\PersonnaliteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonnaliteRepository::class)
 */
class Personnalite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $nation;

    /**
     * @ORM\ManyToMany(targetEntity=Journaliste::class, mappedBy="personnalite")
     */
    private $journalistes;

    public function __construct()
    {
        $this->journalistes = new ArrayCollection();
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

    public function getNation(): ?string
    {
        return $this->nation;
    }

    public function setNation(?string $nation): self
    {
        $this->nation = $nation;

        return $this;
    }

    /**
     * @return Collection|Journaliste[]
     */
    public function getJournalistes(): Collection
    {
        return $this->journalistes;
    }

    public function addJournaliste(Journaliste $journaliste): self
    {
        if (!$this->journalistes->contains($journaliste)) {
            $this->journalistes[] = $journaliste;
            $journaliste->addPersonnalite($this);
        }

        return $this;
    }

    public function removeJournaliste(Journaliste $journaliste): self
    {
        if ($this->journalistes->removeElement($journaliste)) {
            $journaliste->removePersonnalite($this);
        }

        return $this;
    }
}
