<?php

namespace App\Entity;

use App\Repository\INICIATIVASMODULOSRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: INICIATIVASMODULOSRepository::class)]
class INICIATIVASMODULOS
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'modulos')]
    #[ORM\JoinColumn (nullable: true)]
    private ?INICIATIVAS $iniciativa = null;

    #[ORM\ManyToOne(inversedBy: 'iniciativa')]
    #[ORM\JoinColumn (nullable: true)]
    private ?MODULOS $modulo = null;

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

    public function getModulo(): ?MODULOS
    {
        return $this->modulo;
    }

    public function setModulo(?MODULOS $modulo): static
    {
        $this->modulo = $modulo;

        return $this;
    }
}
