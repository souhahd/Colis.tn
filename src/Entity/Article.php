<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @ORM\Table(name="article")
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 */
class Article
{
    use Timestampable;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank(message="Attention titre vide!")
     */
    private $titreArticle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Attention Contenu vide!")
     */
    private $contenuArticle;

    /**
     * @ORM\Column(type="boolean")
     */
    private $visibiliteArticle=true;

    /**
     * @ORM\Column(type="date")
     */
    private $datePubArticle;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank(message="Attention autheur vide!")
     */
    private $auteurArticle;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Attention source vide!")
     */
    private $sourceArticle;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="idArticle")
     */
    private $idCommentaire;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="article_image", fileNameProperty="imageArticle")
     *
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageArticle;

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

    public function getImageArticle(): ?string
    {
        return $this->imageArticle;
    }

    public function setImageArticle(string $imageArticle): self
    {
        $this->imageArticle = $imageArticle;

        return $this;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->setUpdatedAt(new \DateTimeImmutable);
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }
}
