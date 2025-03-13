<?php

namespace App\Service;

use App\Entity\EntidadExterna;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class EntidadesExternasService{


    // Constructor con el manejador de entidades y el serializador
    public function __construct(private EntityManagerInterface $entityManager, private SerializerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    // Funcion para obtener todas las Entidades Externas
    public function getAllEntidadesExternas(): JsonResponse
    {
        $entidadesExternas = $this->entityManager->getRepository(EntidadExterna::class)->findAll();

        if ($entidadesExternas === null) {
            return new JsonResponse(['message' => 'No se han encontrado entidades externas'], JsonResponse::HTTP_NOT_FOUND);
        }

        $json = $this->serializer->serialize($entidadesExternas, 'json');
        return new JsonResponse($json, JsonResponse::HTTP_OK, [], true);
    }
}