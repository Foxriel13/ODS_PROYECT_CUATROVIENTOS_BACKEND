<?php

namespace App\Entity;

use App\Repository\ModuloRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: ModuloRepository::class)]
class Modulo
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
    #[ORM\OneToMany(targetEntity: IniciativaModulo::class, mappedBy: 'modulo')]
    #[Ignore]
    private Collection $iniciativa;

    /**
     * @var Collection<int, ModuloClase>
     */
    #[ORM\OneToMany(targetEntity: ModuloClase::class, mappedBy: 'modulo')]
    #[Ignore]
    private Collection $moduloClases;

    public function __construct()
    {
        $this->iniciativa = new ArrayCollection();
        $this->moduloClases = new ArrayCollection();
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
     * @return Collection<int, IniciativaModulo>
     */
    public function getIniciativa(): Collection
    {
        return $this->iniciativa;
    }

    public function addIniciativa(IniciativaModulo $iniciativa): static
    {
        if (!$this->iniciativa->contains($iniciativa)) {
            $this->iniciativa->add($iniciativa);
            $iniciativa->setModulo($this);
        }
        return $this;
    }

    public function removeIniciativa(IniciativaModulo $iniciativa): static
    {
        if ($this->iniciativa->removeElement($iniciativa)) {
            if ($iniciativa->getModulo() === $this) {
                $iniciativa->setModulo(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, ModuloClase>
     */
    public function getModuloClases(): Collection
    {
        return $this->moduloClases;
    }

    public function addModuloClase(ModuloClase $moduloClase): static
    {
        if (!$this->moduloClases->contains($moduloClase)) {
            $this->moduloClases->add($moduloClase);
            $moduloClase->setModulo($this);
        }

        return $this;
    }

    public function removeModuloClase(ModuloClase $moduloClase): static
    {
        if ($this->moduloClases->removeElement($moduloClase)) {
            // set the owning side to null (unless already changed)
            if ($moduloClase->getModulo() === $this) {
                $moduloClase->setModulo(null);
            }
        }

        return $this;
    }
}
