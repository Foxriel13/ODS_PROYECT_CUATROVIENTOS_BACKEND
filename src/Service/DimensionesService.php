<?php

namespace App\Service;

use App\Entity\Dimension;
use Doctrine\ORM\EntityManagerInterface;
class DimensionesService{

    // Constructor con el manejador de entidades
    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

    }

    // Funcion para obtener todas las dimensiones
    public function getAllDimensiones(): array
    {
        return $this->entityManager->getRepository(Dimension::class)->findAll();
    }

}