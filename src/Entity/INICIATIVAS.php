<?php

namespace App\Entity;

use App\Repository\INICIATIVASRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: INICIATIVASRepository::class)]
class INICIATIVAS
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $accion = null;

    #[ORM\Column]
    private ?int $horas = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $productoFinal = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fechaInicio = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fechaFin = null;

    /**
     * @var Collection<int, METASINICIATIVAS>
     */
    #[ORM\OneToMany(targetEntity: METASINICIATIVAS::class, mappedBy: 'codIniciativa')]
    private Collection $metasIniciativas;

    /**
     * @var Collection<int, INICIATIVASMODULOS>
     */
    #[ORM\OneToMany(targetEntity: INICIATIVASMODULOS::class, mappedBy: 'iniciativa')]
    private Collection $modulos;

    /**
     * @var Collection<int, ENTIDADESEXTERNASINICIATIVAS>
     */
    #[ORM\OneToMany(targetEntity: ENTIDADESEXTERNASINICIATIVAS::class, mappedBy: 'iniciativa')]
    private Collection $entidadesExternas;

    /**
     * @var Collection<int, PROFESORESINICIATIVAS>
     */
    #[ORM\OneToMany(targetEntity: PROFESORESINICIATIVAS::class, mappedBy: 'iniciativa')]
    private Collection $profesores;

    #[ORM\Column]
    private ?bool $eliminado = null;


    public function __construct()
    {
        $this->metasIniciativas = new ArrayCollection();
        $this->modulos = new ArrayCollection();
        $this->entidadesExternas = new ArrayCollection();
        $this->profesores = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccion(): ?string
    {
        return $this->accion;
    }

    public function setAccion(?string $accion): static
    {
        $this->accion = $accion;

        return $this;
    }

    public function getHoras(): ?int
    {
        return $this->horas;
    }

    public function setHoras(int $horas): static
    {
        $this->horas = $horas;

        return $this;
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

    public function getProductoFinal(): ?string
    {
        return $this->productoFinal;
    }

    public function setProductoFinal(?string $productoFinal): static
    {
        $this->productoFinal = $productoFinal;

        return $this;
    }

    public function getFechaInicio(): ?\DateTimeInterface
    {
        return $this->fechaInicio;
    }

    public function setFechaInicio(\DateTimeInterface $fechaInicio): static
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    public function getFechaFin(): ?\DateTimeInterface
    {
        return $this->fechaFin;
    }


    public function setFechaFin(\DateTimeInterface $fechaFin): static
    {
        $this->fechaFin = $fechaFin;

        return $this;
    }
    /**
     * @return Collection<int, METASINICIATIVAS>
     */
    public function getMetasIniciativas(): Collection
    {
        return $this->metasIniciativas;
    }

    public function addMetasIniciativa(METASINICIATIVAS $metasIniciativa): static
    {
        if (!$this->metasIniciativas->contains($metasIniciativa)) {
            $this->metasIniciativas->add($metasIniciativa);
            $metasIniciativa->setCodIniciativa($this);
        }

        return $this;
    }

    public function removeMetasIniciativa(METASINICIATIVAS $metasIniciativa): static
    {
        if ($this->metasIniciativas->removeElement($metasIniciativa)) {
            // set the owning side to null (unless already changed)
            if ($metasIniciativa->getCodIniciativa() === $this) {
                $metasIniciativa->setCodIniciativa(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, INICIATIVASMODULOS>
     */
    public function getModulos(): Collection
    {
        return $this->modulos;
    }

    public function addModulo(INICIATIVASMODULOS $modulo): static
    {
        if (!$this->modulos->contains($modulo)) {
            $this->modulos->add($modulo);
            $modulo->setIniciativa($this);
        }

        return $this;
    }

    public function removeModulo(INICIATIVASMODULOS $modulo): static
    {
        if ($this->modulos->removeElement($modulo)) {
            // set the owning side to null (unless already changed)
            if ($modulo->getIniciativa() === $this) {
                $modulo->setIniciativa(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ENTIDADESEXTERNASINICIATIVAS>
     */
    public function getEntidadesExternas(): Collection
    {
        return $this->entidadesExternas;
    }

    public function addEntidadesExterna(ENTIDADESEXTERNASINICIATIVAS $entidadesExterna): static
    {
        if (!$this->entidadesExternas->contains($entidadesExterna)) {
            $this->entidadesExternas->add($entidadesExterna);
            $entidadesExterna->setIniciativa($this);
        }

        return $this;
    }

    public function removeEntidadesExterna(ENTIDADESEXTERNASINICIATIVAS $entidadesExterna): static
    {
        if ($this->entidadesExternas->removeElement($entidadesExterna)) {
            // set the owning side to null (unless already changed)
            if ($entidadesExterna->getIniciativa() === $this) {
                $entidadesExterna->setIniciativa(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PROFESORESINICIATIVAS>
     */
    public function getProfesores(): Collection
    {
        return $this->profesores;
    }

    public function addProfesor(PROFESORESINICIATIVAS $profesor): static
    {
        if (!$this->profesores->contains($profesor)) {
            $this->profesores->add($profesor);
            $profesor->setIniciativa($this);
        }
 
        return $this;
    }

    public function removeProfesor(PROFESORESINICIATIVAS $profesor): static
    {
        if ($this->profesores->removeElement($profesor)) {
            // set the owning side to null (unless already changed)
            if ($profesor->getIniciativa() === $this) {
                $profesor->setIniciativa(null);
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
