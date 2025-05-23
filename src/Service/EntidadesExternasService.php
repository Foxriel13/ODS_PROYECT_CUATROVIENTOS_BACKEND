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

    // Obtener todas las entidades externas
    public function getAllEntidadesExternas(): JsonResponse
    {
        $entidadesExternas = $this->entityManager->getRepository(EntidadExterna::class)->findAll();

        if (empty($entidadesExternas)) {
            return new JsonResponse(['message' => 'No se han encontrado entidades externas'], Response::HTTP_NO_CONTENT);
        }

        $json = $this->serializer->serialize($entidadesExternas, 'json');
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    // Obtener una entidad externa por ID
    public function getEntidadExternaById(int $id): ?EntidadExterna
    {
        return $this->entityManager->getRepository(EntidadExterna::class)->find($id);
    }

    // Crear una nueva entidad externa
    public function createEntidadExterna(array $data): JsonResponse
    {
        if (!isset($data['nombre'])) {
            return new JsonResponse(['message' => 'El campo "nombre" es obligatorio'], Response::HTTP_BAD_REQUEST);
        }

        $entidadExterna = new EntidadExterna();
        $entidadExterna->setNombre($data['nombre']);
        $entidadExterna->setEliminado(false);

        $this->entityManager->persist($entidadExterna);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Entidad Externa creada correctamente'], Response::HTTP_CREATED);
    }

    // Actualizar una entidad externa
    public function updateEntidadExterna(int $idEntidadExterna, array $data): JsonResponse
    {
        $entidadExterna = $this->getEntidadExternaById($idEntidadExterna);

        if (!$entidadExterna) {
            return new JsonResponse(['message' => 'Entidad Externa no encontrada'], Response::HTTP_NOT_FOUND);
        }

        if (!empty($data['nombre'])) {
            $entidadExterna->setNombre($data['nombre']);
        }

        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Entidad Externa actualizada correctamente'], Response::HTTP_OK);
    }

    // Eliminar una entidad externa
    public function deleteEntidadExterna(int $idEntidadExterna): JsonResponse
    {
        $entidadExterna = $this->entityManager->getRepository(EntidadExterna::class)->find($idEntidadExterna);

        if (!$entidadExterna) {
            return new JsonResponse(['message' => 'La Entidad Externa no ha sido encontrada'], Response::HTTP_NOT_FOUND);
        }

        if ($entidadExterna->isEliminado() == true) {
            return new JsonResponse(['message' => 'La Entidad Externa ya se encontraba eliminada'], Response::HTTP_BAD_REQUEST);
        }

        $entidadExterna->setEliminado(true);
        $this->entityManager->flush();
        return new JsonResponse(['message' => 'La Entidad Externa ha sido eliminado exitosamente'], Response::HTTP_OK);
    }
}