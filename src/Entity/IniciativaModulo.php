<?php

namespace App\Entity;

use App\Repository\IniciativaModuloRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IniciativaModuloRepository::class)]
class IniciativaModulo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'modulo')]
    #[ORM\JoinColumn (nullable: true)]
    private ?Iniciativa $iniciativa = null;

    #[ORM\ManyToOne(inversedBy: 'iniciativa')]
    #[ORM\JoinColumn (nullable: true)]
    private ?Modulo $modulo = null;

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

    public function getModulo(): ?Modulo
    {
        return $this->modulo;
    }

    public function setModulo(?Modulo $modulo): static
    {
        $this->modulo = $modulo;

        return $this;
    }

    public function __construct(Iniciativa $iniciativa, Modulo $modulo) {
        $this->iniciativa = $iniciativa;
        $this->modulo = $modulo;
    }
}
