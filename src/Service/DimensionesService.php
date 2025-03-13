<?php

namespace App\Service;

use App\Entity\Dimension;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
class DimensionesService{

    // Constructor con el manejador de entidades y el serializador
    public function __construct(private EntityManagerInterface $entityManager, private SerializerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    // Funcion para obtener todas las dimensiones
    public function getAllDimensiones(): JsonResponse
    {
        $dimensiones = $this->entityManager->getRepository(Dimension::class)->findAll();

        if ($dimensiones === null) {
            return new JsonResponse(['message' => 'No se han encontrado dimensiones'], JsonResponse::HTTP_NOT_FOUND);
        }

        $json = $this->serializer->serialize($dimensiones, 'json');
        return new JsonResponse($json, JsonResponse::HTTP_OK, [], true);
    }

}