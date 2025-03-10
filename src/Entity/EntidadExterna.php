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
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    /**
     * @var Collection<int, ENTIDADESEXTERNASINICIATIVAS>
     */
    #[ORM\OneToMany(targetEntity: EntidadExternaIniciativa::class, mappedBy: 'entidad')]
    #[IGNORE]
    private Collection $iniciativa;

    public function __construct()
    {
        $this->iniciativa = new ArrayCollection();
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
     * @return Collection<int, ENTIDADESEXTERNASINICIATIVAS>
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
            // set the owning side to null (unless already changed)
            if ($iniciativa->getEntidad() === $this) {
                $iniciativa->setEntidad(null);
            }
        }

        return $this;
    }
}
