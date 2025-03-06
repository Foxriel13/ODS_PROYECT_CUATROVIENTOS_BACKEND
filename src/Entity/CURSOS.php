<?php

namespace App\Entity;

use App\Repository\CURSOSRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: CURSOSRepository::class)]
class CURSOS
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    /**
     * @var Collection<int, MODULOS>
     */
    #[ORM\OneToMany(targetEntity: MODULOS::class, mappedBy: 'curso')]
    #[IGNORE]
    private Collection $modulos;

    public function __construct()
    {
        $this->modulos = new ArrayCollection();
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
     * @return Collection<int, MODULOS>
     */
    public function getModulos(): Collection
    {
        return $this->modulos;
    }

    public function addModulo(MODULOS $modulo): static
    {
        if (!$this->modulos->contains($modulo)) {
            $this->modulos->add($modulo);
            $modulo->setCurso($this);
        }

        return $this;
    }

    public function removeModulo(MODULOS $modulo): static
    {
        if ($this->modulos->removeElement($modulo)) {
            // set the owning side to null (unless already changed)
            if ($modulo->getCurso() === $this) {
                $modulo->setCurso(null);
            }
        }

        return $this;
    }
}
