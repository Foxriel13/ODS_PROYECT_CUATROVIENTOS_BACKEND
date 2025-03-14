<?php

namespace App\Service;

use App\Entity\Clase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;

class ClasesService{

    // Constructor con el manejador de entidades y el serializador
    public function __construct(private EntityManagerInterface $entityManager, private SerializerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    // Funcion para obtener todas las clases
    public function getAllClases(): JsonResponse
    {
        $clases = $this->entityManager->getRepository(Clase::class)->findAll();

        if ($clases === null) {
            return new JsonResponse(['message' => 'No se han encontrado clases'], JsonResponse::HTTP_NOT_FOUND);
        }

        $json = $this->serializer->serialize($clases, 'json');
        return new JsonResponse($json, JsonResponse::HTTP_OK, [], true);
    }

    public function createClase(array $data): JsonResponse
    {
        $clase = new Clase();

        $this->entityManager->persist($clase);
        $clase->setNombre($data['nombre'] ?? null);
        $this->entityManager->flush();
 
        return new JsonResponse([
            'message' => 'Clase creada correctamente',
        ], Response::HTTP_CREATED);
    }

    // Función para actualizar una Clase
    public function updateClase(int $id, array $data): JsonResponse
    {
        $clase = $this->entityManager->getRepository(Clase::class)->find($id);

        if (!$clase) {
            return new JsonResponse([
                'message' => 'Clase no encontrada',
            ], Response::HTTP_NOT_FOUND);
        }

        if (isset($data['nombre'])) {
            $clase->setNombre($data['nombre']);
        }

        $this->entityManager->flush();

        return new JsonResponse([
            'message' => 'Clase actualizada correctamente',
        ], Response::HTTP_OK);
    }

    // Función para eliminar una Clase
    public function deleteClase(int $id): JsonResponse
    {
        $clase = $this->entityManager->getRepository(Clase::class)->find($id);

        if (!$clase) {
            return new JsonResponse([
                'message' => 'Clase no encontrada',
            ], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($clase);
        $this->entityManager->flush();

        return new JsonResponse([
            'message' => 'Clase eliminada correctamente',
        ], Response::HTTP_OK);
    }
 
}