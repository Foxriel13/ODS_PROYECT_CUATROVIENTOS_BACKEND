<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Profesor;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;

class ProfesorService{

    // Constructor con el manejador de entidades y el serializador
    public function __construct(private EntityManagerInterface $entityManager, private SerializerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    // Función para obtener todos los profesores
    public function getAllProfesores(): JsonResponse
{
    $profesores = $this->entityManager->getRepository(Profesor::class)->findAll();

    if (empty($profesores)) {
        return new JsonResponse(['message' => 'No se han encontrado profesores'], Response::HTTP_NOT_FOUND);
    }

    // Mapear manualmente solo los campos deseados
    $data = array_map(function (Profesor $profesor) {
        return [
            'id' => $profesor->getId(),
            'nombre' => $profesor->getNombre(),
        ];
    }, $profesores);

    return new JsonResponse($data, Response::HTTP_OK);
}


    // Función para crear un profesor
    public function createProfesor(array $data): JsonResponse
    {
        if (!isset($data['nombre'])) {
            return new JsonResponse(['message' => 'El campo "nombre" es obligatorio'], Response::HTTP_BAD_REQUEST);
        }

        $profesor = new Profesor();
        $profesor->setNombre($data['nombre'] ?? null);

        $this->entityManager->persist($profesor);
        $this->entityManager->flush();
    
        return new JsonResponse([
            'message' => 'Profesor creado correctamente',
        ], Response::HTTP_CREATED);
    }

    // Función para actualizar un profesor
    public function updateProfesor(int $idProfesor, array $data): JsonResponse
    {
        $profesor = $this->entityManager->getRepository(Profesor::class)->find($idProfesor);

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

    // Función para eliminar un profesor
    public function deleteProfesor(int $idProfesor): JsonResponse
    {
        $profesor = $this->entityManager->getRepository(Profesor::class)->find($idProfesor);

        if (!$profesor) {
            return new JsonResponse([
                'message' => 'Profesor no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($profesor);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Profesor eliminado correctamente'], Response::HTTP_OK);
    }

}