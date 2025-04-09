<?php

namespace App\Service;

use App\Entity\Actividad;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;

class ActividadesService{

    // Constructor con el manejador de entidades y el serializador
    public function __construct(private EntityManagerInterface $entityManager, private SerializerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    // Obtener todas las Actividades
    public function getAllActividades(): JsonResponse
    {
        $actividades = $this->entityManager->getRepository(Actividad::class)->findAll();

        if (empty($actividades)) {
            return new JsonResponse(['message' => 'No se han encontrado actividades'], Response::HTTP_NO_CONTENT);
        }

        $json = $this->serializer->serialize($actividades, 'json');
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    // Crear una nueva Actividad
    public function createActividad(array $data): JsonResponse
    {
        if (!isset($data['nombre'])) {
            return new JsonResponse(['message' => 'El campo "nombre" es obligatorio'], Response::HTTP_BAD_REQUEST);
        }

        $actividad = new Actividad();
        $actividad->setNombre($data['nombre']);

        $this->entityManager->persist($actividad);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Actividad creada correctamente'], Response::HTTP_CREATED);
    }

    // Actualizar una Actividad
    public function updateClase(int $id, array $data): JsonResponse
    {
        $actividad = $this->entityManager->getRepository(Actividad::class)->find($id);

        if (!$actividad) {
            return new JsonResponse(['message' => 'Actividad no encontrada'], Response::HTTP_NOT_FOUND);
        }

        if (!empty($data['nombre'])) {
            $actividad->setNombre($data['nombre']);
        }

        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Actividad actualizada correctamente'], Response::HTTP_OK);
    }

    // Eliminar una Actividad
    public function deleteActividad(int $id): JsonResponse
    {
        $actividad = $this->entityManager->getRepository(Actividad::class)->find($id);

        if (!$actividad) {
            return new JsonResponse(['message' => 'Actividad no encontrada'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($actividad);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Actividad eliminada correctamente'], Response::HTTP_OK);
    }
 
}