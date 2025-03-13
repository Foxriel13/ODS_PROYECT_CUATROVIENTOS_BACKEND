<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ODS;

class ODSService{

    // Constructor con el manejador de entidades
    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

    }

    // Funcion para obtener todas las ODS
    public function getAllOds(): array
    {
        return $this->entityManager->getRepository(ODS::class)->findAll();
    }
}