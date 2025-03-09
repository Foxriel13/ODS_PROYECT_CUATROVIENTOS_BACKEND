<?php

namespace App\Entity;

use App\Repository\METASINICIATIVASRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: METASINICIATIVASRepository::class)]
class METASINICIATIVAS
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'metasIniciativas')]
    #[ORM\JoinColumn(nullable: true)]
    #[IGNORE]
    private ?INICIATIVAS $codIniciativa = null;

    #[ORM\ManyToOne(inversedBy: 'metasIniciativasIdMetas')]
    #[ORM\JoinColumn(nullable: true)]
    private ?METAS $idMetas = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodIniciativa(): ?INICIATIVAS
    {
        return $this->codIniciativa;
    }

    public function setCodIniciativa(?INICIATIVAS $codIniciativa): static
    {
        $this->codIniciativa = $codIniciativa;

        return $this;
    }

    public function getIdMetas(): ?METAS
    {
        return $this->idMetas;
    }

    public function setIdMetas(?METAS $idMetas): static
    {
        $this->idMetas = $idMetas;

        return $this;
    }

    public function __construct(INICIATIVAS $iniciativa, METAS $meta) {
        $this->codIniciativa = $iniciativa;
        $this->idMetas = $meta;
    }
}
