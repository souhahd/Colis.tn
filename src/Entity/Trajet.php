<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\TrajetRepository;
use Doctrine\ORM\Mapping as ORM;
use Monolog\DateTimeImmutable;

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
     */
    private $lieuDepartTrajet;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $lieuArriveeTrajet;

    /**
     * @ORM\Column(type="float")
     */
    private $detourMaxTrajet;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDepart;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $formatObjet;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLieuDepartTrajet(): ?string
    {
        return $this->lieuDepartTrajet;
    }

    public function setLieuDepartTrajet(string $lieuDepartTrajet): self
    {
        $this->lieuDepartTrajet = $lieuDepartTrajet;

        return $this;
    }

    public function getLieuArriveeTrajet(): ?string
    {
        return $this->lieuArriveeTrajet;
    }

    public function setLieuArriveeTrajet(string $lieuArriveeTrajet): self
    {
        $this->lieuArriveeTrajet = $lieuArriveeTrajet;

        return $this;
    }

    public function getDetourMaxTrajet(): ?float
    {
        return $this->detourMaxTrajet;
    }

    public function setDetourMaxTrajet(float $detourMaxTrajet): self
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

    public function setFormatObjet(string $formatObjet): self
    {
        $this->formatObjet = $formatObjet;

        return $this;
    }

}
