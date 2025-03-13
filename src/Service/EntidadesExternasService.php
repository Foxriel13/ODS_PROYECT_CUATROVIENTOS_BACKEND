<?php

namespace App\Service;

use App\Entity\EntidadExterna;
use Doctrine\ORM\EntityManagerInterface;

class EntidadesExternasService{

    // Constructor con el manejador de entidades
    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

    }

    // Funcion para obtener todas las Entidades Externas
    public function getAllEntidadesExternas(): array
    {
        return $this->entityManager->getRepository(EntidadExterna::class)->findAll();
    }
}