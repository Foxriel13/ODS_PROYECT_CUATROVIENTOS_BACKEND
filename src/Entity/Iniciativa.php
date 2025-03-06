<?php

namespace App\Entity;

use App\Repository\IniciativaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IniciativaRepository::class)]
class Iniciativa
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idIniciativa = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tipo = null;

    #[ORM\Column]
    private ?int $horas = null;

    #[ORM\Column(length: 255)]
    private ?string $nombreIniciativa = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $productoFinal = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fechaInicio = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fechaFin = null;

    /**
     * @var Collection<int, MetaIniciativa>
     */
    #[ORM\OneToMany(targetEntity: MetaIniciativa::class, mappedBy: 'codIniciativa')]
    private Collection $metaIniciativa;

    /**
     * @var Collection<int, IniciativaModulo>
     */
    #[ORM\OneToMany(targetEntity: IniciativaModulo::class, mappedBy: 'iniciativa')]
    private Collection $modulo;

    /**
     * @var Collection<int, EntidadExternaIniciativa>
     */
    #[ORM\OneToMany(targetEntity: EntidadExternaIniciativa::class, mappedBy: 'iniciativa')]
    private Collection $entidadExterna;

    /**
     * @var Collection<int, ProfesorIniciativa>
     */
    #[ORM\OneToMany(targetEntity: ProfesorIniciativa::class, mappedBy: 'iniciativa')]
    private Collection $profesor;

    #[ORM\Column]
    private ?bool $eliminado = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imagen = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fechaRegistro = null;

    #[ORM\Column]
    private ?bool $innovador = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $anyoLectivo = null;


    public function __construct()
    {
        $this->metaIniciativa = new ArrayCollection();
        $this->modulo = new ArrayCollection();
        $this->entidadExterna = new ArrayCollection();
        $this->profesor = new ArrayCollection();
    }

    public function getIdIniciativa(): ?int
    {
        return $this->idIniciativa;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(?string $tipo): static
    {
        $this->tipo = $tipo;

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

    public function getNombreIniciativa(): ?string
    {
        return $this->nombreIniciativa;
    }

    public function setNombreIniciativa(string $nombre): static
    {
        $this->nombreIniciativa = $nombre;

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
     * @return Collection<int, MetaIniciativa>
     */
    public function getMetaIniciativa(): Collection
    {
        return $this->metaIniciativa;
    }

    public function addMetaIniciativa(MetaIniciativa $metaIniciativa): static
    {
        if (!$this->metaIniciativa->contains($metaIniciativa)) {
            $this->metaIniciativa->add($metaIniciativa);
            $metaIniciativa->setidIniciativa($this);
        }

        return $this;
        
    }

    public function removeMetaIniciativa(MetaIniciativa $metaIniciativa): static
    {
        if ($this->metaIniciativa->removeElement($metaIniciativa)) {
            // set the owning side to null (unless already changed)
            if ($metaIniciativa->getidIniciativa() === $this) {
                $metaIniciativa->setidIniciativa(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, IniciativaModulo>
     */
    public function getModulo(): Collection
    {
        return $this->modulo;
    }

    public function addModulo(IniciativaModulo $modulo): static
    {
        if (!$this->modulo->contains($modulo)) {
            $this->modulo->add($modulo);
            $modulo->setIniciativa($this);
        }

        return $this;
    }

    public function removeModulo(IniciativaModulo $modulo): static
    {
        if ($this->modulo->removeElement($modulo)) {
            // set the owning side to null (unless already changed)
            if ($modulo->getIniciativa() === $this) {
                $modulo->setIniciativa(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EntidadExternaIniciativa>
     */
    public function getEntidadExterna(): Collection
    {
        return $this->entidadExterna;
    }

    public function addEntidadExterna(EntidadExternaIniciativa $EntidadExterna): static
    {
        if (!$this->entidadExterna->contains($EntidadExterna)) {
            $this->entidadExterna->add($EntidadExterna);
            $EntidadExterna->setIniciativa($this);
        }

        return $this;
    }

    public function removeEntidadExterna(EntidadExternaIniciativa $EntidadExterna): static
    {
        if ($this->entidadExterna->removeElement($EntidadExterna)) {
            // set the owning side to null (unless already changed)
            if ($EntidadExterna->getIniciativa() === $this) {
                $EntidadExterna->setIniciativa(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProfesorIniciativa>
     */
    public function getProfesor(): Collection
    {
        return $this->profesor;
    }

    public function addProfesor(ProfesorIniciativa $profesor): static
    {
        if (!$this->profesor->contains($profesor)) {
            $this->profesor->add($profesor);
            $profesor->setIniciativa($this);
        }
 
        return $this;
    }

    public function removeProfesor(ProfesorIniciativa $profesor): static
    {
        if ($this->profesor->removeElement($profesor)) {
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

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(string $imagen): static
    {
        $this->imagen = $imagen;

        return $this;
    }

    public function getFechaRegistro(): ?\DateTimeInterface
    {
        return $this->fechaRegistro;
    }

    public function setFechaRegistro(?\DateTimeInterface $fechaRegistro): static
    {
        $this->fechaRegistro = $fechaRegistro;

        return $this;
    }

    public function isInnovador(): ?bool
    {
        return $this->innovador;
    }

    public function setInnovador(bool $innovador): static
    {
        $this->innovador = $innovador;

        return $this;
    }

    public function getAnyoLectivo(): ?string
    {
        return $this->anyoLectivo;
    }

    public function setAnyoLectivo(?string $anyoLectivo): static
    {
        $this->anyoLectivo = $anyoLectivo;

        return $this;
    }
}