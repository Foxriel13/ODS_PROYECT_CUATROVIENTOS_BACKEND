<?php

namespace App\Entity;

use App\Repository\MetaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: MetaRepository::class)]
class Meta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idMeta = null;

    #[ORM\ManyToOne(inversedBy: 'Meta')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ODS $idOds = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcionMeta = null;

    /**
     * @var Collection<int, MetaIniciativa>
     */
    #[ORM\OneToMany(targetEntity: MetaIniciativa::class, mappedBy: 'idMeta')]
    #[IGNORE]
    private Collection $metaIniciativas;


    public function __construct()
    {
        $this->metaIniciativas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->idMeta;
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
        return $this->descripcionMeta;
    }

    public function setDescripcion(string $descripcionMeta): static
    {
        $this->descripcionMeta = $descripcionMeta;

        return $this;
    }

    /**
     * @return Collection<int, MetaIniciativa>
     */
    public function getMetaIniciativas(): Collection
    {
        return $this->metaIniciativas;
    }

    public function addMetaIniciativa(MetaIniciativa $metaIniciativa): static
    {
        if (!$this->metaIniciativas->contains($metaIniciativa)) {
            $this->metaIniciativas->add($metaIniciativa);
            $metaIniciativa->setIdMeta($this);
        }

        return $this;
    }

    public function removeMetaIniciativa(MetaIniciativa $MetaIniciativaIdMeta): static
    {
        if ($this->metaIniciativas->removeElement($MetaIniciativaIdMeta)) {
            // set the owning side to null (unless already changed)
            if ($MetaIniciativaIdMeta->getIdMeta() === $this) {
                $MetaIniciativaIdMeta->setIdMeta(null);
            }
        }

        return $this;
    }
}
