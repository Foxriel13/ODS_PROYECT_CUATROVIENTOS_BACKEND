<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Meta;

class MetasService{

    // Constructor con el manejador de entidades
    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

    }

    // Funcion para obtener todas las metas
    public function getAllMetas(): array
    {
        return $this->entityManager->getRepository(Meta::class)->findAll();
    }
}