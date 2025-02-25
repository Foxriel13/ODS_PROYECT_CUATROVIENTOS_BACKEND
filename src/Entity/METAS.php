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
    #[ORM\OneToMany(targetEntity: METASINICIATIVAS::class, mappedBy: 'idMetas')]
    private Collection $metasIniciativasIdMetas;


    public function __construct()
    {
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
