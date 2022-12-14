<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\TrajetRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TrajetRepository::class)
 * @ORM\Table(name="trajet")
 * @ORM\HasLifecycleCallbacks
 */
class Trajet
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
     * @Assert\NotBlank(message="Attention Lieu de depart vide!")
     */
    private $lieuDepartTrajet;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank(message="Attention Lieu d'arrivée vide!")
     */
    private $lieuArriveeTrajet;

    /**
     * @ORM\Column(type="float")
     * @Assert\Type(
     *     type="float",
     *     message="non valide"
     * )
     * @Assert\NotBlank (message="Attention detour max vide!")
     * @Assert\Positive  (message="Attention detour max doit être positif!")
     */
    private $detourMaxTrajet;

    /**
     *
     * @ORM\Column(type="datetime")
     */
    private $dateDepart;

    /**
     * @ORM\Column(type="string", length=3)
     * @Assert\Choice({"XS","S","M","L","XL","XXL"})
     */
    private $formatObjet;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="trajets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $showed=1;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="trajetDone")
     */
    private $userExp;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLieuDepartTrajet(): ?string
    {
        return $this->lieuDepartTrajet;
    }

    public function setLieuDepartTrajet(?string $lieuDepartTrajet): self
    {
        $this->lieuDepartTrajet = $lieuDepartTrajet;

        return $this;
    }

    public function getLieuArriveeTrajet(): ?string
    {
        return $this->lieuArriveeTrajet;
    }

    public function setLieuArriveeTrajet(?string $lieuArriveeTrajet): self
    {
        $this->lieuArriveeTrajet = $lieuArriveeTrajet;

        return $this;
    }

    public function getDetourMaxTrajet(): ?float
    {
        return $this->detourMaxTrajet;
    }

    public function setDetourMaxTrajet(?float $detourMaxTrajet): self
    {
        $this->detourMaxTrajet = $detourMaxTrajet;

        return $this;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->dateDepart;
    }

    public function setDateDepart(\DateTimeInterface $dateDepart): self
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }

    public function getFormatObjet(): ?string
    {
        return $this->formatObjet;
    }

    public function setFormatObjet(?string $formatObjet): self
    {
        $this->formatObjet = $formatObjet;

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

    public function getShowed(): ?bool
    {
        return $this->showed;
    }

    public function setShowed(?bool $showed): self
    {
        $this->showed = $showed;

        return $this;
    }

    public function getUserExp(): ?User
    {
        return $this->userExp;
    }

    public function setUserExp(?User $userExp): self
    {
        $this->userExp = $userExp;

        return $this;
    }

}
