<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $contenuCommentaire;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCommentaire;

    /**
     * @ORM\Column(type="boolean")
     */
    private $visibiliteCommentaire;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="idCommentaire")
     */
    private $idArticle;





    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenuCommentaire(): ?string
    {
        return $this->contenuCommentaire;
    }

    public function setContenuCommentaire(string $contenuCommentaire): self
    {
        $this->contenuCommentaire = $contenuCommentaire;

        return $this;
    }

    public function getDateCommentaire(): ?\DateTimeInterface
    {
        return $this->dateCommentaire;
    }

    public function setDateCommentaire(\DateTimeInterface $dateCommentaire): self
    {
        $this->dateCommentaire = $dateCommentaire;

        return $this;
    }

    public function getVisibiliteCommentaire(): ?bool
    {
        return $this->visibiliteCommentaire;
    }

    public function setVisibiliteCommentaire(bool $visibiliteCommentaire): self
    {
        $this->visibiliteCommentaire = $visibiliteCommentaire;

        return $this;
    }

    public function getIdArticle(): ?Article
    {
        return $this->idArticle;
    }

    public function setIdArticle(?Article $idArticle): self
    {
        $this->idArticle = $idArticle;

        return $this;
    }




}
