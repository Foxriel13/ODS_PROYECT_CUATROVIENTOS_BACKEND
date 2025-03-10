<?php

namespace App\Entity;

use App\Repository\DimensionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: DimensionRepository::class)]
class Dimension
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    /**
     * @var Collection<int, ODS>
     */
    #[ORM\OneToMany(targetEntity: ODS::class, mappedBy: 'dimension')]
    #[IGNORE]
    private Collection $ods;

    public function __construct()
    {
        $this->ods = new ArrayCollection();
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
     * @return Collection<int, ODS>
     */
    public function getOds(): Collection
    {
        return $this->ods;
    }

    public function addOd(ODS $od): static
    {
        if (!$this->ods->contains($od)) {
            $this->ods->add($od);
            $od->setDimension($this);
        }

        return $this;
    }

    public function removeOd(ODS $od): static
    {
        if ($this->ods->removeElement($od)) {
            // set the owning side to null (unless already changed)
            if ($od->getDimension() === $this) {
                $od->setDimension(null);
            }
        }

        return $this;
    }
}
