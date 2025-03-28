<?php

namespace App\Entity;

use App\Repository\ClaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: ClaseRepository::class)]
class Clase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    /**
     * @var Collection<int, Modulo>
     */
    #[ORM\OneToMany(targetEntity: Modulo::class, mappedBy: 'clase')]
    #[Ignore]
    private Collection $modulos;

    /**
     * @var Collection<int, ModuloClase>
     */
    #[ORM\OneToMany(targetEntity: ModuloClase::class, mappedBy: 'clase')]
    #[IGNORE]
    private Collection $moduloClases;

    public function __construct()
    {
        $this->modulos = new ArrayCollection();
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

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * @return Collection<int, Modulo>
     */
    public function getModulos(): Collection
    {
        return $this->modulos;
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
            $moduloClase->setClase($this);
        }

        return $this;
    }

    public function removeModuloClase(ModuloClase $moduloClase): static
    {
        if ($this->moduloClases->removeElement($moduloClase)) {
            // set the owning side to null (unless already changed)
            if ($moduloClase->getClase() === $this) {
                $moduloClase->setClase(null);
            }
        }

        return $this;
    }
}