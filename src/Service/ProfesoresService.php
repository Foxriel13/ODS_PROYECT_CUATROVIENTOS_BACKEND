<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Profesor;

class ProfesoresService{

    // Constructor con el manejador de entidades
    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

    }

    // Funcion para obtener todas las profesores
    public function getAllProfesores(): array
    {
        return $this->entityManager->getRepository(Profesor::class)->findAll();
    }
}