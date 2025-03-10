<?php

namespace App\Entity;

use App\Repository\ProfesorIniciativaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfesorIniciativaRepository::class)]
class ProfesorIniciativa
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne (targetEntity: Iniciativa::class)]
    #[ORM\JoinColumn]
    private ?Iniciativa $iniciativa = null;

    #[ORM\ManyToOne (targetEntity: Profesor::class)]
    #[ORM\JoinColumn]
    private ?Profesor $profesor = null;

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

    public function getProfesor(): ?Profesor
    {
        return $this->profesor;
    }

    public function setProfesor(?Profesor $profesor): static
    {
        $this->profesor = $profesor;

        return $this;
    }

    public function __construct(Iniciativa $iniciativa, Profesor $profesor) {
        $this->iniciativa = $iniciativa;
        $this->profesor = $profesor;
    }
}
