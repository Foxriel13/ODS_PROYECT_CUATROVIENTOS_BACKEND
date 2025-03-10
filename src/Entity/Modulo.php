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

    #[ORM\ManyToOne(targetEntity: Clase::class, inversedBy: 'modulo')]
    private ?Clase $clase = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    /**
     * @var Collection<int, ProfesorModulo>
     */
    #[ORM\OneToMany(targetEntity: ProfesorModulo::class, mappedBy: 'modulo')]
    #[Ignore]
    private Collection $profesores;

    /**
     * @var Collection<int, ProfesorModulo>
     */
    #[ORM\OneToMany(targetEntity: ProfesorModulo::class, mappedBy: 'modulo')]
    #[Ignore]
    private Collection $iniciativa;

    public function __construct()
    {
        $this->profesores = new ArrayCollection();
        $this->iniciativa = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClase(): ?Clase
    {
        return $this->clase;
    }

    public function setClase(?Clase $clase): static
    {
        $this->clase = $clase;
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

    /**
     * @return Collection<int, PROFESORESModulo>
     */
    public function getProfesores(): Collection
    {
        return $this->profesores;
    }

    public function addProfesores(ProfesorModulo $profesores): static
    {
        if (!$this->profesores->contains($profesores)) {
            $this->profesores->add($profesores);
            $profesores->setModulos($this);
        }
        return $this;
    }

    public function removeProfesores(ProfesorModulo $profesores): static
    {
        if ($this->profesores->removeElement($profesores)) {
            if ($profesores->getModulos() === $this) {
                $profesores->setModulos(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, INICIATIVASMODULOS>
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
}
