<?php

namespace App\Entity;

use App\Repository\IniciativaRedSocialRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IniciativaRedSocialRepository::class)]
class IniciativaRedSocial
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'iniciativaRedesSociales')]
    #[ORM\JoinColumn (nullable: true)]
    private ?Iniciativa $iniciativa = null;

    #[ORM\ManyToOne(inversedBy: 'iniciativaRedesSociales')]
    #[ORM\JoinColumn (nullable: true)]
    private ?RedSocial $redSocial = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIniciativa(): ?Iniciativa
    {
        return $this->iniciativa;
    }

    public function setIniciativa(?Iniciativa $iniciativa): static
    {
        $this->iniciativa = $iniciativa;

        return $this;
    }

    public function getRedesSociales(): ?RedSocial
    {
        return $this->redSocial;
    }

    public function setRedesSociales(?RedSocial $redSocial): static
    {
        $this->redSocial = $redSocial;

        return $this;
    }

    public function __construct(Iniciativa $iniciativa, RedSocial $redSocial) {
        $this->iniciativa = $iniciativa;
        $this->redSocial = $redSocial;
    }

}
