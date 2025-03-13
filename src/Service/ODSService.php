<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ODS;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ODSService{

    // Constructor con el manejador de entidades y el serializador
    public function __construct(private EntityManagerInterface $entityManager, private SerializerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    // Funcion para obtener todas las ODS
    public function getAllOds(): JsonResponse
    {
        $ods = $this->entityManager->getRepository(ODS::class)->findAll();

        if ($ods === null) {
            return new JsonResponse(['message' => 'No se han encontrado ODSs'], JsonResponse::HTTP_NOT_FOUND);
        }

        $json = $this->serializer->serialize($ods, 'json');
        return new JsonResponse($json, JsonResponse::HTTP_OK, [], true);
    }
}