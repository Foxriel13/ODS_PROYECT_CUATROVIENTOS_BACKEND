<?php

namespace App\Service;

use App\Entity\Clase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;

class ClaseService{

    // Constructor con el manejador de entidades y el serializador
    public function __construct(private EntityManagerInterface $entityManager, private SerializerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    // Obtener todas las clases
    public function getAllClases(): JsonResponse
    {
        $clases = $this->entityManager->getRepository(Clase::class)->findAll();

        if (empty($clases)) {
            return new JsonResponse(['message' => 'No se han encontrado clases'], Response::HTTP_NO_CONTENT);
        }

        $json = $this->serializer->serialize($clases, 'json');
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    // Crear una nueva clase
    public function createClase(array $data): JsonResponse
    {
        if (!isset($data['nombre'])) {
            return new JsonResponse(['message' => 'El campo "nombre" es obligatorio'], Response::HTTP_BAD_REQUEST);
        }

        $clase = new Clase();
        $clase->setNombre($data['nombre']);

        $this->entityManager->persist($clase);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Clase creada correctamente'], Response::HTTP_CREATED);
    }

    // Actualizar una clase
    public function updateClase(int $idClase, array $data): JsonResponse
    {
        $clase = $this->entityManager->getRepository(Clase::class)->find($idClase);

        if (!$clase) {
            return new JsonResponse(['message' => 'Clase no encontrada'], Response::HTTP_NOT_FOUND);
        }

        if (!empty($data['nombre'])) {
            $clase->setNombre($data['nombre']);
        }

        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Clase actualizada correctamente'], Response::HTTP_OK);
    }

    // Eliminar una clase
    public function deleteClase(int $idClase): JsonResponse
    {
        $clase = $this->entityManager->getRepository(Clase::class)->find($idClase);

        if (!$clase) {
            return new JsonResponse(['message' => 'Clase no encontrada'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($clase);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Clase eliminada correctamente'], Response::HTTP_OK);
    }
 
}