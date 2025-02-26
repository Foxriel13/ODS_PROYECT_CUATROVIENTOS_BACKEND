<?php

namespace App\Entity;

use App\Repository\ENTIDADESEXTERNASINICIATIVASRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ENTIDADESEXTERNASINICIATIVASRepository::class)]
class ENTIDADESEXTERNASINICIATIVAS
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'entidadesExternas')]
    #[ORM\Column (nullable: true)]
    private ?INICIATIVAS $iniciativa = null;

    #[ORM\ManyToOne(inversedBy: 'iniciativa')]
    #[ORM\Column (nullable: true)]
    private ?ENTIDADESEXTERNAS $entidad = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIniciativa(): ?INICIATIVAS
    {
        return $this->iniciativa;
    }

    public function setIniciativa(?INICIATIVAS $iniciativa): static
    {
        $this->iniciativa = $iniciativa;

        return $this;
    }

    public function getEntidad(): ?ENTIDADESEXTERNAS
    {
        return $this->entidad;
    }

    public function setEntidad(?ENTIDADESEXTERNAS $entidad): static
    {
        $this->entidad = $entidad;

        return $this;
    }
}
