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
    #[ORM\JoinColumn]
    #[ORM\Column (nullable: false)]

    private ?INICIATIVAS $iniciativa = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn]
    #[ORM\Column (nullable: false)]

    private ?PROFESORES $profesor = null;

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

    public function getProfesor(): ?PROFESORES
    {
        return $this->profesor;
    }

    public function setProfesor(?PROFESORES $profesor): static
    {
        $this->profesor = $profesor;

        return $this;
    }
}
