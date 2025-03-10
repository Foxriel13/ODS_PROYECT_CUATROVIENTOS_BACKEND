<?php

namespace App\Entity;

use App\Repository\EntidadExternaIniciativaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntidadExternaIniciativaRepository::class)]
class EntidadExternaIniciativa
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'entidadExterna')]
    #[ORM\JoinColumn (nullable: true)]
    private ?Iniciativa $iniciativa = null;

    #[ORM\ManyToOne(inversedBy: 'iniciativa')]
    #[ORM\JoinColumn (nullable: true)]
    private ?EntidadExterna $entidad = null;

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

    public function getEntidad(): ?EntidadExterna
    {
        return $this->entidad;
    }

    public function setEntidad(?EntidadExterna $entidad): static
    {
        $this->entidad = $entidad;

        return $this;
    }

    public function __construct(Iniciativa $iniciativa, EntidadExterna $entidadExterna) {
        $this->iniciativa = $iniciativa;
        $this->entidad = $entidadExterna;
    }
}
