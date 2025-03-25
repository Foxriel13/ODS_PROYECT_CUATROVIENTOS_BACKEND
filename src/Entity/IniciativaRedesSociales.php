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
    private ?Iniciativa $iniciativa = null;

    #[ORM\ManyToOne(inversedBy: 'iniciativaRedesSociales')]
    private ?RedesSociales $redesSociales = null;

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

}
