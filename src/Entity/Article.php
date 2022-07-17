<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $titreArticle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contenuArticle;

    /**
     * @ORM\Column(type="boolean")
     */
    private $visibiliteArticle;

    /**
     * @ORM\Column(type="date")
     */
    private $datePubArticle;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $auteurArticle;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $sourceArticle;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="idArticle")
     */
    private $idCommentaire;

    public function __construct()
    {
        $this->idCommentaire = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreArticle(): ?string
    {
        return $this->titreArticle;
    }

    public function setTitreArticle(string $titreArticle): self
    {
        $this->titreArticle = $titreArticle;

        return $this;
    }

    public function getContenuArticle(): ?string
    {
        return $this->contenuArticle;
    }

    public function setContenuArticle(string $contenuArticle): self
    {
        $this->contenuArticle = $contenuArticle;

        return $this;
    }

    public function getVisibiliteArticle(): ?bool
    {
        return $this->visibiliteArticle;
    }

    public function setVisibiliteArticle(bool $visibiliteArticle): self
    {
        $this->visibiliteArticle = $visibiliteArticle;

        return $this;
    }

    public function getDatePubArticle(): ?\DateTimeInterface
    {
        return $this->datePubArticle;
    }

    public function setDatePubArticle(\DateTimeInterface $datePubArticle): self
    {
        $this->datePubArticle = $datePubArticle;

        return $this;
    }

    public function getAuteurArticle(): ?string
    {
        return $this->auteurArticle;
    }

    public function setAuteurArticle(string $auteurArticle): self
    {
        $this->auteurArticle = $auteurArticle;

        return $this;
    }

    public function getSourceArticle(): ?string
    {
        return $this->sourceArticle;
    }

    public function setSourceArticle(string $sourceArticle): self
    {
        $this->sourceArticle = $sourceArticle;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getIdCommentaire(): Collection
    {
        return $this->idCommentaire;
    }

    public function addIdCommentaire(Commentaire $idCommentaire): self
    {
        if (!$this->idCommentaire->contains($idCommentaire)) {
            $this->idCommentaire[] = $idCommentaire;
            $idCommentaire->setIdArticle($this);
        }

        return $this;
    }

    public function removeIdCommentaire(Commentaire $idCommentaire): self
    {
        if ($this->idCommentaire->removeElement($idCommentaire)) {
            // set the owning side to null (unless already changed)
            if ($idCommentaire->getIdArticle() === $this) {
                $idCommentaire->setIdArticle(null);
            }
        }

        return $this;
    }

}
