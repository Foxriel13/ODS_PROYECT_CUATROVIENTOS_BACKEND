<?php

namespace App\Entity;

use App\Repository\CursoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: CursoRepository::class)]
class Curso
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idCurso = null;

    #[ORM\Column(length: 255)]
    private ?string $nombreCurso = null;

    /**
     * @var Collection<int, Modulo>
     */
    #[ORM\OneToMany(targetEntity: Modulo::class, mappedBy: 'curso')]
    #[IGNORE]
    private Collection $modulo;

    public function __construct()
    {
        $this->modulo = new ArrayCollection();
    }

    public function getIdCurso(): ?int
    {
        return $this->idCurso;
    }

    public function getNombreCurso(): ?string
    {
        return $this->nombreCurso;
    }

    public function setNombreCurso(string $nombreCurso): static
    {
        $this->nombreCurso = $nombreCurso;

        return $this;
    }

    /**
     * @return Collection<int, Modulo>
     */
    public function getModulo(): Collection
    {
        return $this->modulo;
    }

    public function addModulo(Modulo $modulo): static
    {
        if (!$this->modulo->contains($modulo)) {
            $this->modulo->add($modulo);
            $modulo->setCurso($this);
        }

        return $this;
    }

    public function removeModulo(Modulo $modulo): static
    {
        if ($this->modulo->removeElement($modulo)) {
            // set the owning side to null (unless already changed)
            if ($modulo->getCurso() === $this) {
                $modulo->setCurso(null);
            }
        }

        return $this;
        
    }
}
