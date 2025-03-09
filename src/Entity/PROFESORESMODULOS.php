<?php

namespace App\Entity;

use App\Repository\PROFESORESMODULOSRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: PROFESORESMODULOSRepository::class)]
class PROFESORESMODULOS
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'modulos')]
    #[IGNORE]
    private ?PROFESORES $profesor = null;

    #[ORM\ManyToOne(inversedBy: 'profesores')]
    private ?MODULOS $modulos = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getModulos(): ?MODULOS
    {
        return $this->modulos;
    }

    public function setModulos(?MODULOS $modulos): static
    {
        $this->modulos = $modulos;

        return $this;
    }


}
