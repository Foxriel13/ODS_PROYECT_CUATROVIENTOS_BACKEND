<?php

namespace App\Entity;

use App\Repository\ProfesorModuloRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: ProfesorModuloRepository::class)]
class ProfesorModulo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'modulo')]
    #[IGNORE]
    private ?Profesor $profesor = null;

    #[ORM\ManyToOne(inversedBy: 'profesores')]
    private ?Modulo $modulos = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProfesor(): ?Profesor
    {
        return $this->profesor;
    }

    public function setProfesor(?Profesor $profesor): static
    {
        $this->profesor = $profesor;

        return $this;
    }

    public function getModulos(): ?Modulo
    {
        return $this->modulos;
    }

    public function setModulos(?Modulo $modulos): static
    {
        $this->modulos = $modulos;

        return $this;
    }


}
