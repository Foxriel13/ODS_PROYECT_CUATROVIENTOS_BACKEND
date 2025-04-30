<?php

namespace App\Entity;

use App\Repository\ActividadRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActividadRepository::class)]
class Actividad
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    /**
     * @var Collection<int, IniciativaActividad>
     */
    #[ORM\OneToMany(targetEntity: IniciativaActividad::class, mappedBy: 'actividad')]
    private Collection $iniciativaActividads;

    #[ORM\Column]
    private ?bool $eliminado = null;

    public function __construct()
    {
        $this->iniciativaActividads = new ArrayCollection();
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
     * @return Collection<int, IniciativaActividad>
     */
    public function getIniciativaActividads(): Collection
    {
        return $this->iniciativaActividads;
    }

    public function addIniciativaActividad(IniciativaActividad $iniciativaActividad): static
    {
        if (!$this->iniciativaActividads->contains($iniciativaActividad)) {
            $this->iniciativaActividads->add($iniciativaActividad);
            $iniciativaActividad->setActividad($this);
        }

        return $this;
    }

    public function removeIniciativaActividad(IniciativaActividad $iniciativaActividad): static
    {
        if ($this->iniciativaActividads->removeElement($iniciativaActividad)) {
            // set the owning side to null (unless already changed)
            if ($iniciativaActividad->getActividad() === $this) {
                $iniciativaActividad->setActividad(null);
            }
        }

        return $this;
    }

    public function isEliminado(): ?bool
    {
        return $this->eliminado;
    }

    public function setEliminado(bool $eliminado): static
    {
        $this->eliminado = $eliminado;

        return $this;
    }
}
