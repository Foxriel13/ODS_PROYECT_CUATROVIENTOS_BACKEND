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

    // Obtener todas las dimensiones
    public function getAllDimensiones(): JsonResponse
    {
        $dimensiones = $this->entityManager->getRepository(Dimension::class)->findAll();

        if (empty($dimensiones)) {
            return new JsonResponse(['message' => 'No se han encontrado dimensiones'], Response::HTTP_NO_CONTENT);
        }

        $json = $this->serializer->serialize($dimensiones, 'json');
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    // Obtener una dimensión por ID
    public function getDimensionById(int $id): ?Dimension
    {
        return $this->entityManager->getRepository(Dimension::class)->find($id);
    }

    // Crear una nueva dimensión
    public function createDimension(array $data): JsonResponse
    {
        if (!isset($data['nombre'])) {
            return new JsonResponse(['message' => 'El campo "nombre" es obligatorio'], Response::HTTP_BAD_REQUEST);
        }

        $dimension = new Dimension();
        $dimension->setNombre($data['nombre']);

        $this->entityManager->persist($dimension);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Dimensión creada correctamente'], Response::HTTP_CREATED);
    }

    // Actualizar una dimensión
    public function updateDimension(int $id, array $data): JsonResponse
    {
        $dimension = $this->getDimensionById($id);

        if (!$dimension) {
            return new JsonResponse(['message' => 'Dimensión no encontrada'], Response::HTTP_NOT_FOUND);
        }

        if (!empty($data['nombre'])) {
            $dimension->setNombre($data['nombre']);
        }

        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Dimensión actualizada correctamente'], Response::HTTP_OK);
    }

    // Eliminar una dimensión
    public function deleteDimension(int $id): JsonResponse
    {
        $dimension = $this->getDimensionById($id);

        if (!$dimension) {
            return new JsonResponse(['message' => 'Dimensión no encontrada'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($dimension);
        $this->entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

}