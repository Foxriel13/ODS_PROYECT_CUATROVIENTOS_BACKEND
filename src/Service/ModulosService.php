<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Modulo;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class ModulosService{

    // Constructor con el manejador de entidades y el serializador
    public function __construct(private EntityManagerInterface $entityManager, private SerializerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    // Funcion para obtener todas las modulos
    public function getAllModulos(): JsonResponse
    {
        $modulos = $this->entityManager->getRepository(Modulo::class)->findAll();

        if ($modulos === null) {
            return new JsonResponse(['message' => 'No se han encontrado modulos'], JsonResponse::HTTP_NOT_FOUND);
        }

        $json = $this->serializer->serialize($modulos, 'json');
        return new JsonResponse($json, JsonResponse::HTTP_OK, [], true);
    }
}