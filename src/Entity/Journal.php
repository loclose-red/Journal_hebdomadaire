<?php

namespace App\Entity;

use App\Repository\JournalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=JournalRepository::class)
 */
class Journal
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\OneToMany(targetEntity=Journaliste::class, mappedBy="journal")
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

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
            $journaliste->setJournal($this);
        }

        return $this;
    }

    public function removeJournaliste(Journaliste $journaliste): self
    {
        if ($this->journalistes->removeElement($journaliste)) {
            // set the owning side to null (unless already changed)
            if ($journaliste->getJournal() === $this) {
                $journaliste->setJournal(null);
            }
        }

        return $this;
    }
}
