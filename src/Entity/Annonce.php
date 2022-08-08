<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank(message="Attention l'adresse de départ doit être non vide!")
     */
    private $adresseDepart;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Attention l'adresse d'arrivé doit être non vide!")
     */
    private $adresseArrivee;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Le prix doit être non vide! ")
     * @Assert\Positive(message="Le prix doit être positif!")
     * @Assert\NotNull (message="Le prix doit être non nulle!")
     */
    private $prixProposee;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime (message="Cette valeur n'est pas une date valide!")
     *
     */
    private $dateProposee;


    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity=Colis::class, inversedBy="annonce", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $colis;

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


    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getColis(): ?Colis
    {
        return $this->colis;
    }

    public function setColis(Colis $colis): self
    {
        $this->colis = $colis;

        return $this;
    }
}
