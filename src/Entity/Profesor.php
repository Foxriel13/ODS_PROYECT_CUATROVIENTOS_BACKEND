<?php

namespace App\Entity;

use App\Repository\ProfesorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Collection;

#[ORM\Entity(repositoryClass: ProfesorRepository::class)]
class Profesor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    /**
     * @var \Doctrine\Common\Collections\Collection<int, ProfesorIniciativa>
     */
    #[ORM\OneToMany(targetEntity: ProfesorIniciativa::class, mappedBy: 'profesor')]
    private \Doctrine\Common\Collections\Collection $profesorIniciativas;

    #[ORM\Column(length: 255)]
    private ?string $rol = null;

    public function __construct()
    {
        $this->profesorIniciativas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection<int, ProfesorIniciativa>
     */
    public function getProfesorIniciativas(): \Doctrine\Common\Collections\Collection
    {
        return $this->profesorIniciativas;
    }

    public function addProfesorIniciativa(ProfesorIniciativa $profesorIniciativa): static
    {
        if (!$this->profesorIniciativas->contains($profesorIniciativa)) {
            $this->profesorIniciativas->add($profesorIniciativa);
            $profesorIniciativa->setProfesor($this);
        }

        return $this;
    }

    public function removeProfesorIniciativa(ProfesorIniciativa $profesorIniciativa): static
    {
        if ($this->profesorIniciativas->removeElement($profesorIniciativa)) {
            // set the owning side to null (unless already changed)
            if ($profesorIniciativa->getProfesor() === $this) {
                $profesorIniciativa->setProfesor(null);
            }
        }

        return $this;
    }

    public function getRol(): ?string
    {
        return $this->rol;
    }

    public function setRol(string $rol): static
    {
        $this->rol = $rol;

        return $this;
    }
    
}
