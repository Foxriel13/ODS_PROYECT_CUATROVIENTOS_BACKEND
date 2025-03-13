<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Modulo;

class ModulosService{

    // Constructor con el manejador de entidades
    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

    }

    // Funcion para obtener todas las modulos
    public function getAllModulos(): array
    {
        return $this->entityManager->getRepository(Modulo::class)->findAll();
    }
}