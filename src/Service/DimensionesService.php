<?php

namespace App\Service;

use App\Entity\Dimension;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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

    public function createDimension(array $data): JsonResponse
    {
        $dimension = new Dimension();

        $this->entityManager->persist($dimension);
        $dimension->setNombre($data['nombre'] ?? null);
        $this->entityManager->flush();
 
        return new JsonResponse([
            'message' => 'Dimension creada correctamente',
        ], Response::HTTP_CREATED);
    }
    
    // Función para actualizar una Dimensión
    public function updateDimension(int $id, array $data): JsonResponse
    {
        $dimension = $this->entityManager->getRepository(Dimension::class)->find($id);

        if (!$dimension) {
            return new JsonResponse([
                'message' => 'Dimensión no encontrada',
            ], Response::HTTP_NOT_FOUND);
        }

        if (isset($data['nombre'])) {
            $dimension->setNombre($data['nombre']);
        }

        $this->entityManager->flush();

        return new JsonResponse([
            'message' => 'Dimensión actualizada correctamente',
        ], Response::HTTP_OK);
    }

    // Función para eliminar una Dimensión
    public function deleteDimension(int $id): JsonResponse
    {
        $dimension = $this->entityManager->getRepository(Dimension::class)->find($id);

        if (!$dimension) {
            return new JsonResponse([
                'message' => 'Dimensión no encontrada',
            ], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($dimension);
        $this->entityManager->flush();

        return new JsonResponse([
            'message' => 'Dimensión eliminada correctamente',
        ], Response::HTTP_OK);
    }

}