<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\JournalisteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=JournalisteRepository::class)
 * @ApiResource()
 */


class Journaliste
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
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateNaiss;

    /**
     * @ORM\ManyToMany(targetEntity=Personnalite::class, inversedBy="journalistes")
     */
    private $personnalite;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="journaliste")
     */
    private $articles;

    /**
     * @ORM\ManyToOne(targetEntity=Journal::class, inversedBy="journalistes")
     */
    private $journal;

    public function __construct()
    {
        $this->personnalite = new ArrayCollection();
        $this->articles = new ArrayCollection();
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

    public function getDateNaiss(): ?\DateTimeInterface
    {
        return $this->dateNaiss;
    }

    public function setDateNaiss(?\DateTimeInterface $dateNaiss): self
    {
        $this->dateNaiss = $dateNaiss;

        return $this;
    }

    /**
     * @return Collection|Personnalite[]
     */
    public function getPersonnalite(): Collection
    {
        return $this->personnalite;
    }

    public function addPersonnalite(Personnalite $personnalite): self
    {
        if (!$this->personnalite->contains($personnalite)) {
            $this->personnalite[] = $personnalite;
        }

        return $this;
    }

    public function removePersonnalite(Personnalite $personnalite): self
    {
        $this->personnalite->removeElement($personnalite);

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setJournaliste($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getJournaliste() === $this) {
                $article->setJournaliste(null);
            }
        }

        return $this;
    }

    public function getJournal(): ?Journal
    {
        return $this->journal;
    }

    public function setJournal(?Journal $journal): self
    {
        $this->journal = $journal;

        return $this;
    }
}
