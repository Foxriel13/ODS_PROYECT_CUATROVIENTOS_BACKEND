<?php

namespace App\Entity;

use App\Repository\OdsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: OdsRepository::class)]
class Ods
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idOds = null;

    #[ORM\Column(length: 255)]
    private ?string $nombreOds = null;

    /**
     * @var Collection<int, Meta>
     */
    #[ORM\OneToMany(targetEntity: Meta::class, mappedBy: 'ods')]
    #[IGNORE]
    private Collection $metas;

    #[ORM\ManyToOne(inversedBy: 'Ods')]
    private ?Dimension $dimension = null;

    public function __construct()
    {
        $this->metas = new ArrayCollection();
    }

    public function getidOds(): ?int
    {
        return $this->idOds;
    }

    public function getNombreOds(): ?string
    {
        return $this->nombreOds;
    }

    public function setNombreOds(string $nombreOds): static
    {
        $this->nombreOds = $nombreOds;

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
            $meta->setidOds($this);
        }

        return $this;
    }

    public function removeMeta(Meta $meta): static
    {
        if ($this->metas->removeElement($meta)) {
            // set the owning sidOdse to null (unless already changed)
            if ($meta->getidOds() === $this) {
                $meta->setidOds(null);
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
