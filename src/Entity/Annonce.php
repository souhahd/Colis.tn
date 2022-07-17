<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnnonceRepository::class)
 */
class Annonce
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
    private $adresseDepart;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $adresseArrivee;

    /**
     * @ORM\Column(type="float")
     */
    private $prixProposee;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateProposee;

    /**
     * @ORM\OneToMany(targetEntity=Colis::class, mappedBy="idAnnonce", orphanRemoval=true)
     */
    private $idColis;

    public function __construct()
    {
        $this->idColis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresseDepart(): ?string
    {
        return $this->adresseDepart;
    }

    public function setAdresseDepart(string $adresseDepart): self
    {
        $this->adresseDepart = $adresseDepart;

        return $this;
    }

    public function getAdresseArrivee(): ?string
    {
        return $this->adresseArrivee;
    }

    public function setAdresseArrivee(string $adresseArrivee): self
    {
        $this->adresseArrivee = $adresseArrivee;

        return $this;
    }

    public function getPrixProposee(): ?float
    {
        return $this->prixProposee;
    }

    public function setPrixProposee(float $prixProposee): self
    {
        $this->prixProposee = $prixProposee;

        return $this;
    }

    public function getDateProposee(): ?\DateTimeInterface
    {
        return $this->dateProposee;
    }

    public function setDateProposee(\DateTimeInterface $dateProposee): self
    {
        $this->dateProposee = $dateProposee;

        return $this;
    }

    /**
     * @return Collection<int, Colis>
     */
    public function getIdColis(): Collection
    {
        return $this->idColis;
    }

    public function addIdColi(Colis $idColi): self
    {
        if (!$this->idColis->contains($idColi)) {
            $this->idColis[] = $idColi;
            $idColi->setIdAnnonce($this);
        }

        return $this;
    }

    public function removeIdColi(Colis $idColi): self
    {
        if ($this->idColis->removeElement($idColi)) {
            // set the owning side to null (unless already changed)
            if ($idColi->getIdAnnonce() === $this) {
                $idColi->setIdAnnonce(null);
            }
        }

        return $this;
    }
}
