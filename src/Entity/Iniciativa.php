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
    private ?int $id = null;

    #[ORM\Column]
    private ?int $horas = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $explicacion = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fechaInicio = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fechaFin = null;

    /**
     * @var Collection<int, MetaIniciativa>
     */
    #[ORM\OneToMany(targetEntity: MetaIniciativa::class, mappedBy: 'codIniciativa')]
    private Collection $metasIniciativas;

    /**
     * @var Collection<int, IniciativaModulo>
     */
    #[ORM\OneToMany(targetEntity: IniciativaModulo::class, mappedBy: 'iniciativa')]
    private Collection $modulos;

    /**
     * @var Collection<int, EntidadExternaIniciativa>
     */
    #[ORM\OneToMany(targetEntity: EntidadExternaIniciativa::class, mappedBy: 'iniciativa')]
    private Collection $entidadesExternas;

    /**
     * @var Collection<int, ProfesorIniciativa>
     */
    #[ORM\OneToMany(targetEntity: ProfesorIniciativa::class, mappedBy: 'iniciativa')]
    private Collection $profesores;

    #[ORM\Column]
    private ?bool $eliminado = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imagen = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fechaRegistro = null;

    #[ORM\Column]
    private ?bool $innovador = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $anyoLectivo = null;

    #[ORM\Column(length: 255)]
    private ?string $masComentarios = null;

    /**
     * @var Collection<int, IniciativaRedesSociales>
     */
    #[ORM\OneToMany(targetEntity: IniciativaRedesSociales::class, mappedBy: 'iniciativa')]
    private Collection $iniciativaRedesSociales;

    /**
     * @var Collection<int, IniciativaActividad>
     */
    #[ORM\OneToMany(targetEntity: IniciativaActividad::class, mappedBy: 'iniciativa', cascade: ["persist"])]
    private Collection $iniciativaActividades;


    public function __construct()
    {
        $this->metasIniciativas = new ArrayCollection();
        $this->modulos = new ArrayCollection();
        $this->entidadesExternas = new ArrayCollection();
        $this->profesores = new ArrayCollection();
        $this->iniciativaRedesSociales = new ArrayCollection();
        $this->iniciativaActividades = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getExplicacion(): ?string
    {
        return $this->explicacion;
    }

    public function setExplicacion(?string $explicacion): static
    {
        $this->explicacion = $explicacion;

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
    public function getMetasIniciativas(): Collection
    {
        return $this->metasIniciativas;
    }

    public function addMetasIniciativa(MetaIniciativa $metasIniciativa): static
    {
        if (!$this->metasIniciativas->contains($metasIniciativa)) {
            $this->metasIniciativas->add($metasIniciativa);
            $metasIniciativa->setCodIniciativa($this);
        }

        return $this;
    }

    public function removeMetasIniciativa(MetaIniciativa $metasIniciativa): static
    {
        if ($this->metasIniciativas->removeElement($metasIniciativa)) {
            if ($metasIniciativa->getCodIniciativa() === $this) {
                $metasIniciativa->setCodIniciativa(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, IniciativaModulo>
     */
    public function getModulos(): Collection
    {
        return $this->modulos;
    }

    public function addModulo(IniciativaModulo $modulo): static
    {
        if (!$this->modulos->contains($modulo)) {
            $this->modulos->add($modulo);
            $modulo->setIniciativa($this);
        }

        return $this;
    }

    public function removeModulo(IniciativaModulo $modulo): static
    {
        if ($this->modulos->removeElement($modulo)) {
            if ($modulo->getIniciativa() === $this) {
                $modulo->setIniciativa(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EntidadExternaIniciativa>
     */
    public function getEntidadesExternas(): Collection
    {
        return $this->entidadesExternas;
    }

    public function addEntidadesExterna(EntidadExternaIniciativa $entidadesExterna): static
    {
        if (!$this->entidadesExternas->contains($entidadesExterna)) {
            $this->entidadesExternas->add($entidadesExterna);
            $entidadesExterna->setIniciativa($this);
        }

        return $this;
    }

    public function removeEntidadesExterna(EntidadExternaIniciativa $entidadesExterna): static
    {
        if ($this->entidadesExternas->removeElement($entidadesExterna)) {
            if ($entidadesExterna->getIniciativa() === $this) {
                $entidadesExterna->setIniciativa(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProfesorInicitiva>
     */
    public function getProfesores(): Collection
    {
        return $this->profesores;
    }

    public function addProfesor(ProfesorIniciativa $profesor): static
    {
        if (!$this->profesores->contains($profesor)) {
            $this->profesores->add($profesor);
            $profesor->setIniciativa($this);
        }
 
        return $this;
    }

    public function removeProfesor(ProfesorIniciativa $profesor): static
    {
        if ($this->profesores->removeElement($profesor)) {
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

    public function getMasComentarios(): ?string
    {
        return $this->masComentarios;
    }

    public function setMasComentarios(string $masComentarios): static
    {
        $this->masComentarios = $masComentarios;

        return $this;
    }

    /**
     * @return Collection<int, IniciativaRedesSociales>
     */
    public function getIniciativaRedesSociales(): Collection
    {
        return $this->iniciativaRedesSociales;
    }

    public function addIniciativaRedesSociale(IniciativaRedesSociales $iniciativaRedesSociale): static
    {
        if (!$this->iniciativaRedesSociales->contains($iniciativaRedesSociale)) {
            $this->iniciativaRedesSociales->add($iniciativaRedesSociale);
            $iniciativaRedesSociale->setIniciativa($this);
        }

        return $this;
        
    }

    public function removeIniciativaRedesSociale(IniciativaRedesSociales $iniciativaRedesSociale): static
    {
        if ($this->iniciativaRedesSociales->removeElement($iniciativaRedesSociale)) {
            // set the owning side to null (unless already changed)
            if ($iniciativaRedesSociale->getIniciativa() === $this) {
                $iniciativaRedesSociale->setIniciativa(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, IniciativaActividad>
     */
    public function getIniciativaActividades(): Collection
    {
        return $this->iniciativaActividades;
    }

    public function addIniciativaActividad(IniciativaActividad $iniciativaActividad): static
    {
        if (!$this->iniciativaActividades->contains($iniciativaActividad)) {
            $this->iniciativaActividades->add($iniciativaActividad);
            $iniciativaActividad->setIniciativa($this);
        }

        return $this;
    }

    public function removeIniciativaActividad(IniciativaActividad $iniciativaActividad): static
    {
        if ($this->iniciativaActividades->removeElement($iniciativaActividad)) {
            // set the owning side to null (unless already changed)
            if ($iniciativaActividad->getIniciativa() === $this) {
                $iniciativaActividad->setIniciativa(null);
            }
        }

        return $this;
    }
    
}