<?php

namespace App\Service;

use App\Entity\Clase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class ClasesService{

    // Constructor con el manejador de entidades y el serializador
    public function __construct(private EntityManagerInterface $entityManager, private SerializerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    // Funcion para obtener todas las clases
    public function getAllClases(): JsonResponse
    {
        $clases = $this->entityManager->getRepository(Clase::class)->findAll();

        if ($clases === null) {
            return new JsonResponse(['message' => 'No se han encontrado clases'], JsonResponse::HTTP_NOT_FOUND);
        }

        $json = $this->serializer->serialize($clases, 'json');
        return new JsonResponse($json, JsonResponse::HTTP_OK, [], true);
    }

}