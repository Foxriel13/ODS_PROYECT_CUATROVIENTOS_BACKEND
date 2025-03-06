<?php

namespace App\Entity;

use App\Repository\EntidadExternaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: EntidadExternaRepository::class)]
class EntidadExterna
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idEntidadExterna = null;

    #[ORM\Column(length: 255)]
    private ?string $nombreEntidadExterna = null;

    /**
     * @var Collection<int, EntidadExternaIniciativa>
     */
    #[ORM\OneToMany(targetEntity: EntidadExternaIniciativa::class, mappedBy: 'entidadexterna')]
    #[IGNORE]
    private Collection $iniciativa;

    public function __construct()
    {
        $this->iniciativa = new ArrayCollection();
    }

    public function getIdEntidadExterna(): ?int
    {
        return $this->idEntidadExterna;
    }

    public function getNombreEntidadExterna(): ?string
    {
        return $this->nombreEntidadExterna;
    }

    public function setNombreEntidadExterna(string $nombreEntidadExterna): static
    {
        $this->nombreEntidadExterna = $nombreEntidadExterna;

        return $this;
    }

    /**
     * @return Collection<int, EntidEntidadExternaadExternaIniciativa>
     */
    public function getIniciativa(): Collection
    {
        return $this->iniciativa;
    }

    public function addIniciativa(EntidadExternaIniciativa $iniciativa): static
    {
        if (!$this->iniciativa->contains($iniciativa)) {
            $this->iniciativa->add($iniciativa);
            $iniciativa->setEntidad($this);
        }

        return $this;
    }

    public function removeIniciativa(EntidadExternaIniciativa $iniciativa): static
    {
        if ($this->iniciativa->removeElement($iniciativa)) {
            // set the owning sidEntidadExternae to null (unless already changed)
            if ($iniciativa->getIniciativa() === $this) {
                $iniciativa->setIniciativa(null);
            }
        }

        return $this;
    }
}
