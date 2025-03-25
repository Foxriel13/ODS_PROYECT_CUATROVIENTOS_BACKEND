<?php

namespace App\Entity;

use App\Repository\RedesSocialesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RedesSocialesRepository::class)]
class RedesSociales
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $enlace = null;

    /**
     * @var Collection<int, IniciativaRedesSociales>
     */
    #[ORM\OneToMany(targetEntity: IniciativaRedesSociales::class, mappedBy: 'redesSociales')]
    private Collection $iniciativaRedesSociales;

    public function __construct()
    {
        $this->iniciativaRedesSociales = new ArrayCollection();
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

    public function getEnlace(): ?string
    {
        return $this->enlace;
    }

    public function setEnlace(string $enlace): static
    {
        $this->enlace = $enlace;

        return $this;
    }

    /**
     * @return Collection<int, IniciativaRedesSociales>
     */
    public function getIniciativaRedesSociales(): Collection
    {
        return $this->iniciativaRedesSociales;
    }

    public function addIniciativaRedesSociale(IniciativaRedesSociales $iniciativaRedesSociale): static
    {
        if (!$this->iniciativaRedesSociales->contains($iniciativaRedesSociale)) {
            $this->iniciativaRedesSociales->add($iniciativaRedesSociale);
            $iniciativaRedesSociale->setRedesSociales($this);
        }

        return $this;
    }

    public function removeIniciativaRedesSociale(IniciativaRedesSociales $iniciativaRedesSociale): static
    {
        if ($this->iniciativaRedesSociales->removeElement($iniciativaRedesSociale)) {
            // set the owning side to null (unless already changed)
            if ($iniciativaRedesSociale->getRedesSociales() === $this) {
                $iniciativaRedesSociale->setRedesSociales(null);
            }
        }

        return $this;
    }

}
