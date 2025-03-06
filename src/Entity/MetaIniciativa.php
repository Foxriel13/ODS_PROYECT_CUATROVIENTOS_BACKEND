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

    #[ORM\ManyToOne(inversedBy: 'MetaIniciativa')]
    #[ORM\JoinColumn(nullable: true)]
    #[IGNORE]
    private ?Iniciativa $idIniciativa = null;

    #[ORM\ManyToOne(inversedBy: 'MetaIniciativaIdMeta')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Meta $idMeta = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getidIniciativa(): ?Iniciativa
    {
        return $this->idIniciativa;
    }

    public function setidIniciativa(?Iniciativa $idIniciativa): static
    {
        $this->idIniciativa = $idIniciativa;

        return $this;
    }

    public function getIdMeta(): ?Meta
    {
        return $this->idMeta;
    }

    public function setIdMeta(?Meta $idMeta): static
    {
        $this->idMeta = $idMeta;

        return $this;
    }
}
