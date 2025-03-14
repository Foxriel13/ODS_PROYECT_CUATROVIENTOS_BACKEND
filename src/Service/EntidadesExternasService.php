<?php

namespace App\Service;

use App\Entity\EntidadExterna;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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

    // Funcion para crear una Entidad Externa
    public function createEntidadExterna(array $data): JsonResponse
    {
        $entidadExterna = new EntidadExterna();

        $this->entityManager->persist($entidadExterna);
        $entidadExterna->setNombre($data['nombre'] ?? null);
        $this->entityManager->flush();
 
        return new JsonResponse([
            'message' => 'Entidad Externa creada correctamente',
        ], Response::HTTP_CREATED);
    }
 
    // Función para actualizar una Entidad Externa
    public function updateEntidadExterna(int $id, array $data): JsonResponse
    {
        $entidadExterna = $this->entityManager->getRepository(EntidadExterna::class)->find($id);

        if (!$entidadExterna) {
            return new JsonResponse([
                'message' => 'Entidad Externa no encontrada',
            ], Response::HTTP_NOT_FOUND);
        }

        if (isset($data['nombre'])) {
            $entidadExterna->setNombre($data['nombre']);
        }

        $this->entityManager->flush();

        return new JsonResponse([
            'message' => 'Entidad Externa actualizada correctamente',
        ], Response::HTTP_OK);
    }

    // Función para eliminar una Entidad Externa
    public function deleteEntidadExterna(int $id): JsonResponse
    {
        $entidadExterna = $this->entityManager->getRepository(EntidadExterna::class)->find($id);

        if (!$entidadExterna) {
            return new JsonResponse([
                'message' => 'Entidad Externa no encontrada',
            ], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($entidadExterna);
        $this->entityManager->flush();

        return new JsonResponse([
            'message' => 'Entidad Externa eliminada correctamente',
        ], Response::HTTP_OK);
    }
}