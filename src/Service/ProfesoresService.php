<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Profesor;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class ProfesoresService{

    // Constructor con el manejador de entidades y el serializador
    public function __construct(private EntityManagerInterface $entityManager, private SerializerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    // Funcion para obtener todas las profesores
    public function getAllProfesores(): JsonResponse
    {
        $profesores = $this->entityManager->getRepository(Profesor::class)->findAll();

        if ($profesores === null) {
            return new JsonResponse(['message' => 'No se han encontrado profesores'], JsonResponse::HTTP_NOT_FOUND);
        }

        $json = $this->serializer->serialize($profesores, 'json');
        return new JsonResponse($json, JsonResponse::HTTP_OK, [], true);
    }
}