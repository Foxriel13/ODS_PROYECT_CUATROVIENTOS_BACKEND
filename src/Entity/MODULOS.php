<?php

namespace App\Entity;

use App\Repository\MODULOSRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: MODULOSRepository::class)]
class MODULOS
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'modulos')]
    private ?CURSOS $curso = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    /**
     * @var Collection<int, PROFESORESMODULOS>
     */
    #[ORM\OneToMany(targetEntity: PROFESORESMODULOS::class, mappedBy: 'modulos')]
    #[IGNORE]
    private Collection $profesores;

    /**
     * @var Collection<int, INICIATIVASMODULOS>
     */
    #[ORM\OneToMany(targetEntity: INICIATIVASMODULOS::class, mappedBy: 'modulo')]
    #[IGNORE]
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

    public function getCurso(): ?CURSOS
    {
        return $this->curso;
    }

    public function setCurso(?CURSOS $curso): static
    {
        $this->curso = $curso;

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
     * @return Collection<int, PROFESORESMODULOS>
     */
    public function getProfesores(): Collection
    {
        return $this->profesores;
    }

    public function addProfesore(PROFESORESMODULOS $profesore): static
    {
        if (!$this->profesores->contains($profesore)) {
            $this->profesores->add($profesore);
            $profesore->setModulos($this);
        }

        return $this;
    }

    public function removeProfesore(PROFESORESMODULOS $profesore): static
    {
        if ($this->profesores->removeElement($profesore)) {
            // set the owning side to null (unless already changed)
            if ($profesore->getModulos() === $this) {
                $profesore->setModulos(null);
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

    public function addIniciativa(INICIATIVASMODULOS $iniciativa): static
    {
        if (!$this->iniciativa->contains($iniciativa)) {
            $this->iniciativa->add($iniciativa);
            $iniciativa->setModulo($this);
        }

        return $this;
    }

    public function removeIniciativa(INICIATIVASMODULOS $iniciativa): static
    {
        if ($this->iniciativa->removeElement($iniciativa)) {
            // set the owning side to null (unless already changed)
            if ($iniciativa->getModulo() === $this) {
                $iniciativa->setModulo(null);
            }
        }

        return $this;
    }

}
