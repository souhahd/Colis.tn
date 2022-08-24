<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\ColisRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ColisRepository::class)
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks
 */
class Colis
{
    use Timestampable;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank(message="Attention l'objet vide!")
     */
    private $objetColis;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotNull(message="Attention le quantite doit not null")
     * @Assert\Positive(message="Attention quantite doit être positive!")
     */
    private $quantiteColis;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotNull(message="Attention le largeur doit not null")
     * @Assert\Positive(message="Attention largeur doit être positive!")
     */
    private $largeurColis;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotNull(message="Attention le longeur doit not null")
     * @Assert\Positive(message="Attention longeur doit être positive!")
     */
    private $longeurColis;

    /**
     * @ORM\Column(type="float")
     *@Assert\NotNull(message="Attention l'hauteur doit not null")
     * @Assert\Positive(message="Attention l'hauteur doit être positive!")
     */
    private $hauteurColis;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotNull(message="Attention le poids unitaire doit not null")
     * @Assert\Positive(message="Attention le poids unitaire doit être positive!")
     */
    private $poidsUnitaireColis;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Image(
     *     minHeight=200,
     *     maxHeight=400,
     *     minWidth=200,
     *     maxWidth=400
     * )
     */
    private $image;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Attention la description doit être non vide!")
    */
    private $descriptionColis;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="colis_image", fileNameProperty="image")
     *
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\OneToOne(targetEntity=Annonce::class, mappedBy="colis", cascade={"persist", "remove"})
     */
    private $annonce;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getObjetColis(): ?string
    {
        return $this->objetColis;
    }

    public function setObjetColis(string $objetColis): self
    {
        $this->objetColis = $objetColis;

        return $this;
    }

    public function getQuantiteColis(): ?int
    {
        return $this->quantiteColis;
    }

    public function setQuantiteColis(int $quantiteColis): self
    {
        $this->quantiteColis = $quantiteColis;

        return $this;
    }

    public function getLargeurColis(): ?float
    {
        return $this->largeurColis;
    }

    public function setLargeurColis(float $largeurColis): self
    {
        $this->largeurColis = $largeurColis;

        return $this;
    }

    public function getLongeurColis(): ?float
    {
        return $this->longeurColis;
    }

    public function setLongeurColis(float $longeurColis): self
    {
        $this->longeurColis = $longeurColis;

        return $this;
    }

    public function getHauteurColis(): ?float
    {
        return $this->hauteurColis;
    }

    public function setHauteurColis(float $hauteurColis): self
    {
        $this->hauteurColis = $hauteurColis;

        return $this;
    }

    public function getPoidsUnitaireColis(): ?float
    {
        return $this->poidsUnitaireColis;
    }

    public function setPoidsUnitaireColis(float $poidsUnitaireColis): self
    {
        $this->poidsUnitaireColis = $poidsUnitaireColis;

        return $this;
    }


    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDescriptionColis(): ?string
    {
        return $this->descriptionColis;
    }

    public function setDescriptionColis(string $descriptionColis): self
    {
        $this->descriptionColis = $descriptionColis;

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

    public function getAnnonce(): ?Annonce
    {
        return $this->annonce;
    }

    public function setAnnonce(Annonce $annonce): self
    {
        // set the owning side of the relation if necessary
        if ($annonce->getColis() !== $this) {
            $annonce->setColis($this);
        }

        $this->annonce = $annonce;

        return $this;
    }

}
