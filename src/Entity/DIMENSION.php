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
    private ?int $idDimension = null;

    #[ORM\Column(length: 255)]
    private ?string $nombreDimension = null;

    /**
     * @var Collection<int, Ods>
     */
    #[ORM\OneToMany(targetEntity: Ods::class, mappedBy: 'dimension')]
    #[IGNORE]
    private Collection $Ods;

    public function __construct()
    {
        $this->Ods = new ArrayCollection();
    }

    public function getIdDimension(): ?int
    {
        return $this->idDimension;
    }

    public function getNombreDimension(): ?string
    {
        return $this->nombreDimension;
    }

    public function setNombreDimension(string $nombreDimension): static
    {
        $this->nombreDimension = $nombreDimension;

        return $this;
    }

    /**
     * @return Collection<int, Ods>
     */
    public function getOds(): Collection
    {
        return $this->Ods;
    }

    public function addOds(Ods $ods): static
    {
        if (!$this->Ods->contains($ods)) {
            $this->Ods->add($ods);
            $ods->setDimension($this);
        }

        return $this;
    }

    public function removeOds(Ods $ods): static
    {
        if ($this->Ods->removeElement($ods)) {
            // set the owning side to null (unless already changed)
            if ($ods->getDimension() === $this) {
                $ods->setDimension(null);
            }
        }

        return $this;
    }
}
