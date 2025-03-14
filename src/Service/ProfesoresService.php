<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Profesor;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;

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

    // Funcion para crear un profesor
    public function createProfesor(array $data): JsonResponse
    {
        $profesor = new Profesor();

        $this->entityManager->persist($profesor);
        $profesor->setNombre($data['nombre'] ?? null);
        $this->entityManager->flush();
    
        return new JsonResponse([
            'message' => 'Profesor creada correctamente',
        ], Response::HTTP_CREATED);
    }

    // Función para actualizar un Profesor
    public function updateProfesor(int $id, array $data): JsonResponse
    {
        $profesor = $this->entityManager->getRepository(Profesor::class)->find($id);

        if (!$profesor) {
            return new JsonResponse([
                'message' => 'Profesor no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        if (isset($data['nombre'])) {
            $profesor->setNombre($data['nombre']);
        }

        $this->entityManager->flush();

        return new JsonResponse([
            'message' => 'Profesor actualizado correctamente',
        ], Response::HTTP_OK);
    }

    // Función para eliminar un Profesor
    public function deleteProfesor(int $id): JsonResponse
    {
        $profesor = $this->entityManager->getRepository(Profesor::class)->find($id);

        if (!$profesor) {
            return new JsonResponse([
                'message' => 'Profesor no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($profesor);
        $this->entityManager->flush();

        return new JsonResponse([
            'message' => 'Profesor eliminado correctamente',
        ], Response::HTTP_OK);
    }

}