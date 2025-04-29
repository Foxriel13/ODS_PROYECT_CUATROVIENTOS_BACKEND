<?php

namespace App\Entity;

use App\Repository\ODSRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: ODSRepository::class)]
class ODS
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    /**
     * @var Collection<int, Meta>
     */
    #[ORM\OneToMany(targetEntity: Meta::class, mappedBy: 'idOds')]
    #[IGNORE]
    private Collection $metas;

    #[ORM\Column(length: 255)]
    private ?string $dimension = null;

    #[ORM\Column]
    private ?bool $eliminado = null;

    public function __construct()
    {
        $this->metas = new ArrayCollection();
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
     * @return Collection<int, Meta>
     */
    public function getMetas(): Collection
    {
        return $this->metas;
    }

    public function addMeta(Meta $meta): static
    {
        if (!$this->metas->contains($meta)) {
            $this->metas->add($meta);
            $meta->setOds($this);
        }

        return $this;
    }

    public function removeMeta(Meta $meta): static
    {
        if ($this->metas->removeElement($meta)) {
            if ($meta->getOds() === $this) {
                $meta->setOds(null);
            }
        }

        return $this;
    }

    public function getDimension(): ?string
    {
        return $this->dimension;
    }

    public function setDimension(string $dimension): static
    {
        $this->dimension = $dimension;

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
