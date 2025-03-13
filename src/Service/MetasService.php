<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Meta;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class MetasService{

    // Constructor con el manejador de entidades y el serializador
    public function __construct(private EntityManagerInterface $entityManager, private SerializerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    // Funcion para obtener todas las metas
    public function getAllMetas(): JsonResponse
    {
        $metas = $this->entityManager->getRepository(Meta::class)->findAll();

        if ($metas === null) {
            return new JsonResponse(['message' => 'No se han encontrado metas'], JsonResponse::HTTP_NOT_FOUND);
        }

        $json = $this->serializer->serialize($metas, 'json');
        return new JsonResponse($json, JsonResponse::HTTP_OK, [], true);
    }
}