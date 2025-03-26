<?php

namespace App\Entity;

use App\Repository\IniciativaRedesSocialesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IniciativaRedesSocialesRepository::class)]
class IniciativaRedesSociales
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'iniciativaRedesSociales')]
    #[ORM\JoinColumn (nullable: true)]
    private ?Iniciativa $iniciativa = null;

    #[ORM\ManyToOne(inversedBy: 'iniciativaRedesSociales')]
    #[ORM\JoinColumn (nullable: true)]
    private ?RedesSociales $redesSociales = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIniciativa(): ?Iniciativa
    {
        return $this->iniciativa;
    }

    public function setIniciativa(?Iniciativa $iniciativa): static
    {
        $this->iniciativa = $iniciativa;

        return $this;
    }

    public function getRedesSociales(): ?RedesSociales
    {
        return $this->redesSociales;
    }

    public function setRedesSociales(?RedesSociales $redesSociales): static
    {
        $this->redesSociales = $redesSociales;

        return $this;
    }

    public function __construct(Iniciativa $iniciativa, RedesSociales $redesSociales) {
        $this->iniciativa = $iniciativa;
        $this->redesSociales = $redesSociales;
    }

}
