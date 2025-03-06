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
    private ?int $idModulo = null;

    #[ORM\ManyToOne(inversedBy: 'Modulo')]
    private ?Curso $curso = null;

    #[ORM\Column(length: 255)]
    private ?string $nombreModulo = null;

    /**
     * @var Collection<int, IniciativaModulo>
     */
    #[ORM\OneToMany(targetEntity: IniciativaModulo::class, mappedBy: 'modulo')]
    #[IGNORE]
    private Collection $iniciativa;

    public function __construct()
    {
        $this->iniciativa = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->idModulo;
    }

    public function getCurso(): ?Curso
    {
        return $this->curso;
    }

    public function setCurso(?Curso $curso): static
    {
        $this->curso = $curso;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombreModulo;
    }

    public function setNombre(string $nombreModulo): static
    {
        $this->nombreModulo = $nombreModulo;

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
            // set the owning side to null (unless already changed)
            if ($iniciativa->getModulo() === $this) {
                $iniciativa->setModulo(null);
            }
        }

        return $this;
    }

}
