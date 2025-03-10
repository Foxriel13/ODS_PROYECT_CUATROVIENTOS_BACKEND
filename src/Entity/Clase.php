<?php

namespace App\Entity;

use App\Repository\ClaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: ClaseRepository::class)]
class Clase
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
    #[ORM\OneToMany(targetEntity: Modulo::class, mappedBy: 'clase')]
    #[Ignore]
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

    public function setNombre(string $nombre): self
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

    public function addModulo(Modulo $modulo): self
    {
        if (!$this->modulos->contains($modulo)) {
            $this->modulos->add($modulo);
            $modulo->setClase($this);
        }
        return $this;
    }

    public function removeModulo(Modulo $modulo): self
    {
        if ($this->modulos->removeElement($modulo)) {
            // Si la relación aún apunta a esta entidad, se la desasigna.
            if ($modulo->getClase() === $this) {
                $modulo->setClase(null);
            }
        }
        return $this;
    }
}
