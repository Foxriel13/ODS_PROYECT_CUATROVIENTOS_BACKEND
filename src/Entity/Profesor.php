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
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    /**
     * @var Collection<int, ProfesorModulo>
     */
    #[ORM\OneToMany(targetEntity: ProfesorModulo::class, mappedBy: 'profesor')]
    private Collection $modulos;

    public function __construct()
    {
        $this->modulos = new ArrayCollection();
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
     * @return Collection<int, ProfesorModulo>
     */
    public function getModulos(): Collection
    {
        return $this->modulos;
    }

    public function addModulo(ProfesorModulo $modulo): static
    {
        if (!$this->modulos->contains($modulo)) {
            $this->modulos->add($modulo);
            $modulo->setProfesor($this);
        }

        return $this;
    }

    public function removeModulo(ProfesorModulo $modulo): static
    {
        if ($this->modulos->removeElement($modulo)) {
            // set the owning side to null (unless already changed)
            if ($modulo->getProfesor() === $this) {
                $modulo->setProfesor(null);
            }
        }

        return $this;
    }

}
