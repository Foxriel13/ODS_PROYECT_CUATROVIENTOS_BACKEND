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
     * @var Collection<int, METAS>
     */
    #[ORM\OneToMany(targetEntity: Meta::class, mappedBy: 'idOds')]
    #[IGNORE]
    private Collection $metas;

    #[ORM\ManyToOne(inversedBy: 'ods')]
    private ?Dimension $dimension = null;

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
     * @return Collection<int, METAS>
     */
    public function getMetas(): Collection
    {
        return $this->metas;
    }

    public function addMeta(Meta $meta): static
    {
        if (!$this->metas->contains($meta)) {
            $this->metas->add($meta);
            $meta->setIdOds($this);
        }

        return $this;
    }

    public function removeMeta(Meta $meta): static
    {
        if ($this->metas->removeElement($meta)) {
            // set the owning side to null (unless already changed)
            if ($meta->getIdOds() === $this) {
                $meta->setIdOds(null);
            }
        }

        return $this;
    }

    public function getDimension(): ?Dimension
    {
        return $this->dimension;
    }

    public function setDimension(?Dimension $dimension): static
    {
        $this->dimension = $dimension;

        return $this;
    }
}
