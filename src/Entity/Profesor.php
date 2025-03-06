<?php

namespace App\Entity;

use App\Repository\ProfesorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfesorRepository::class)]
class Profesor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idProfesor = null;

    #[ORM\Column(length: 255)]
    private ?string $nombreProfesor = null;

    public function getIdProfesor(): ?int
    {
        return $this->idProfesor;
    }

    public function getNombreProfesor(): ?string
    {
        return $this->nombreProfesor;
    }

    public function setNombreProfesor(string $nombreProfesor): static
    {
        $this->nombreProfesor = $nombreProfesor;

        return $this;
    }

}
