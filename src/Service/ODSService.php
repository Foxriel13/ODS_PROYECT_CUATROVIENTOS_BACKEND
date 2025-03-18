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

    // Función para obtener todas las ODS
    public function getAllOds(): JsonResponse
    {
        $ods = $this->entityManager->getRepository(ODS::class)->findAll();

        if (empty($ods)) {
            return new JsonResponse(['message' => 'No se han encontrado ODS'], Response::HTTP_NOT_FOUND);
        }

        $json = $this->serializer->serialize($ods, 'json');
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    // Función para crear un ODS
    public function createOds(array $data): JsonResponse
    {
        $ods = new ODS();

        if (empty($data['nombre'])) {
            return new JsonResponse(['message' => 'El nombre es obligatorio'], Response::HTTP_BAD_REQUEST);
        }

        if (empty($data['ods'])) {
            return new JsonResponse(['message' => 'La dimension es obligatoria'], Response::HTTP_BAD_REQUEST);
        }

        $ods->setNombre($data['nombre']);

        $dimension = $this->entityManager->getRepository(Dimension::class)->find($data['dimension']);
        if ($dimension !== null) {
            $ods->setDimension($dimension);
        }else{
            return new JsonResponse([
                'message' => 'Dimensión no encontrada',
            ], Response::HTTP_NOT_FOUND);
        }
    
        $this->entityManager->persist($ods);
        $this->entityManager->flush();
    
        return new JsonResponse([
            'message' => 'ODS creado correctamente',
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

        $dimension = $this->entityManager->getRepository(Dimension::class)->find($id);
        if ($dimension !== null) {
            $ods->addDimension($dimension);
        }else {
            return new JsonResponse([
                'message' => 'Dimensión no encontrada',
            ], Response::HTTP_BAD_REQUEST);
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