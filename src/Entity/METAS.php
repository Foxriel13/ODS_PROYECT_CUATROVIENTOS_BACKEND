<?php

namespace App\Entity;

use App\Repository\METASRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: METASRepository::class)]
class METAS
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'metas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ODS $idOds = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    /**
     * @var Collection<int, METASINICIATIVAS>
     */
    #[ORM\OneToMany(targetEntity: METASINICIATIVAS::class, mappedBy: 'idOds')]
    private Collection $metasIniciativasIdOds;

    /**
     * @var Collection<int, METASINICIATIVAS>
     */
    #[ORM\OneToMany(targetEntity: METASINICIATIVAS::class, mappedBy: 'idMetas')]
    private Collection $metasIniciativasIdMetas;


    public function __construct()
    {
        $this->metasIniciativas = new ArrayCollection();
        $this->metasIniciativasIdMetas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdOds(): ?ODS
    {
        return $this->idOds;
    }

    public function setIdOds(?ODS $idOds): static
    {
        $this->idOds = $idOds;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * @return Collection<int, INICIATIVAS>
     */
    public function getIniciativas(): Collection
    {
        return $this->iniciativas;
    }

    public function addIniciativa(INICIATIVAS $iniciativa): static
    {
        if (!$this->iniciativas->contains($iniciativa)) {
            $this->iniciativas->add($iniciativa);
        }

        return $this;
    }

    public function removeIniciativa(INICIATIVAS $iniciativa): static
    {
        $this->iniciativas->removeElement($iniciativa);

        return $this;
    }

    /**
     * @return Collection<int, METASINICIATIVAS>
     */
    public function getMetasIniciativas(): Collection
    {
        return $this->metasIniciativas;
    }

    public function addMetasIniciativa(METASINICIATIVAS $metasIniciativa): static
    {
        if (!$this->metasIniciativas->contains($metasIniciativa)) {
            $this->metasIniciativas->add($metasIniciativa);
            $metasIniciativa->setIdOds($this);
        }

        return $this;
    }

    public function removeMetasIniciativa(METASINICIATIVAS $metasIniciativa): static
    {
        if ($this->metasIniciativas->removeElement($metasIniciativa)) {
            // set the owning side to null (unless already changed)
            if ($metasIniciativa->getIdOds() === $this) {
                $metasIniciativa->setIdOds(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, METASINICIATIVAS>
     */
    public function getMetasIniciativasIdMetas(): Collection
    {
        return $this->metasIniciativasIdMetas;
    }

    public function addMetasIniciativasIdMeta(METASINICIATIVAS $metasIniciativasIdMeta): static
    {
        if (!$this->metasIniciativasIdMetas->contains($metasIniciativasIdMeta)) {
            $this->metasIniciativasIdMetas->add($metasIniciativasIdMeta);
            $metasIniciativasIdMeta->setIdMetas($this);
        }

        return $this;
    }

    public function removeMetasIniciativasIdMeta(METASINICIATIVAS $metasIniciativasIdMeta): static
    {
        if ($this->metasIniciativasIdMetas->removeElement($metasIniciativasIdMeta)) {
            // set the owning side to null (unless already changed)
            if ($metasIniciativasIdMeta->getIdMetas() === $this) {
                $metasIniciativasIdMeta->setIdMetas(null);
            }
        }

        return $this;
    }
}
