<?php

namespace App\Entity;

use App\Repository\MetaIniciativaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: MetaIniciativaRepository::class)]
class MetaIniciativa
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'metasIniciativas')]
    #[ORM\JoinColumn(nullable: true)]
    #[IGNORE]
    private ?Iniciativa $codIniciativa = null;

    #[ORM\ManyToOne(inversedBy: 'metasIniciativasIdMetas')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Meta $idMetas = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodIniciativa(): ?Iniciativa
    {
        return $this->codIniciativa;
    }

    public function setCodIniciativa(?Iniciativa $codIniciativa): static
    {
        $this->codIniciativa = $codIniciativa;

        return $this;
    }

    public function getIdMetas(): ?Meta
    {
        return $this->idMetas;
    }

    public function setIdMetas(?Meta $idMetas): static
    {
        $this->idMetas = $idMetas;

        return $this;
    }

    public function __construct(Iniciativa $iniciativa, Meta $meta) {
        $this->codIniciativa = $iniciativa;
        $this->idMetas = $meta;
    }
}
