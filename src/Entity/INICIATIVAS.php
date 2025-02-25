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


    public function __construct()
    {
        $this->metasIniciativas = new ArrayCollection();
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
     * @return Collection<int, METAS>
     */
    public function getMetas(): Collection
    {
        return $this->metas;
    }

    public function addMeta(METAS $meta): static
    {
        if (!$this->metas->contains($meta)) {
            $this->metas->add($meta);
            $meta->addIniciativa($this);
        }

        return $this;
    }

    public function removeMeta(METAS $meta): static
    {
        if ($this->metas->removeElement($meta)) {
            $meta->removeIniciativa($this);
        }

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
}
