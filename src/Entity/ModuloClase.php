<?php

namespace App\Entity;

use App\Repository\ModuloClaseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModuloClaseRepository::class)]
class ModuloClase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'moduloClases')]
    private ?Modulo $modulo = null;

    #[ORM\ManyToOne(inversedBy: 'moduloClases')]
    private ?Clase $clase = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getClase(): ?Clase
    {
        return $this->clase;
    }

    public function setClase(?Clase $clase): static
    {
        $this->clase = $clase;

        return $this;
    }
}
