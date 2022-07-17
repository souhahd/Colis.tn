<?php

namespace App\Entity;

use App\Repository\ColisRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ColisRepository::class)
 */
class Colis
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $objetColis;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantiteColis;

    /**
     * @ORM\Column(type="float")
     */
    private $largeurColis;

    /**
     * @ORM\Column(type="float")
     */
    private $longeurColis;

    /**
     * @ORM\Column(type="float")
     */
    private $hauteurColis;

    /**
     * @ORM\Column(type="float")
     */
    private $poidsUnitaireColis;

    /**
     * @ORM\ManyToOne(targetEntity=Annonce::class, inversedBy="idColis")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idAnnonce;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

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

    public function getIdAnnonce(): ?Annonce
    {
        return $this->idAnnonce;
    }

    public function setIdAnnonce(?Annonce $idAnnonce): self
    {
        $this->idAnnonce = $idAnnonce;

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
}
