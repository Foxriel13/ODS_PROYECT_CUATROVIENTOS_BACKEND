<?php

namespace App\Service;

use App\Entity\Dimension;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ODS;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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

    // Funcion para crear un ODS
    public function createOds(array $data): JsonResponse
    {
        $ods = new ODS();

        $this->entityManager->persist($ods);
        $ods->setNombre($data['nombre'] ?? null);

        if (!empty($data['dimension']) && is_array($data['dimension'])) {
            foreach ($data['dimension'] as $dimension) {
                $dimension = $this->entityManager->getRepository(Dimension::class)->find($dimension);
                if ($dimension !== null) {
                    $ods->setDimension($dimension);
                }
            }
        }

        $this->entityManager->flush();
    
        return new JsonResponse([
            'message' => 'Meta creada correctamente',
        ], Response::HTTP_CREATED);
    }

    // Función para actualizar un ODS
    public function updateOds(int $id, array $data): JsonResponse
    {
        $ods = $this->entityManager->getRepository(ODS::class)->find($id);

        if (!$ods) {
            return new JsonResponse([
                'message' => 'ODS no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        if (isset($data['nombre'])) {
            $ods->setNombre($data['nombre']);
        }

        if (!empty($data['dimension']) && is_array($data['dimension'])) {
            $dimensionEntities = [];
            foreach ($data['dimension'] as $dimensionId) {
                $dimension = $this->entityManager->getRepository(Dimension::class)->find($dimensionId);
                if ($dimension !== null) {
                    $dimensionEntities[] = $dimension;
                }
            }

            if (!empty($dimensionEntities)) {
                // Suponiendo que setDimension puede aceptar múltiples Dimensiones relacionadas
                $ods->setDimension($dimensionEntities);
            } else {
                return new JsonResponse([
                    'message' => 'Debes de introducir al menos una dimensión válida',
                ], Response::HTTP_BAD_REQUEST);
            }
        }

        $this->entityManager->flush();

        return new JsonResponse([
            'message' => 'ODS actualizado correctamente',
        ], Response::HTTP_OK);
    }

    // Función para eliminar un ODS
    public function deleteOds(int $id): JsonResponse
    {
        $ods = $this->entityManager->getRepository(ODS::class)->find($id);

        if (!$ods) {
            return new JsonResponse([
                'message' => 'ODS no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($ods);
        $this->entityManager->flush();

        return new JsonResponse([
            'message' => 'ODS eliminado correctamente',
        ], Response::HTTP_OK);
    }

}