<?php

namespace App\Entity;

use App\Repository\PROFESORESINICIATIVASRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PROFESORESINICIATIVASRepository::class)]
class PROFESORESINICIATIVAS
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?INICIATIVAS $iniciativa = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?PROFESORES $trabajador = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIniciativa(): ?INICIATIVAS
    {
        return $this->iniciativa;
    }

    public function setIniciativa(?INICIATIVAS $iniciativa): static
    {
        $this->iniciativa = $iniciativa;

        return $this;
    }

    public function getTrabajador(): ?PROFESORES
    {
        return $this->trabajador;
    }

    public function setTrabajador(?PROFESORES $trabajador): static
    {
        $this->trabajador = $trabajador;

        return $this;
    }
}
