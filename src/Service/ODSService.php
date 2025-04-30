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

        if (empty($data['dimension'])) {
            return new JsonResponse(['message' => 'La dimension es obligatoria'], Response::HTTP_BAD_REQUEST);
        }

        $ods->setNombre($data['nombre']);
        $ods->setDimension($data['dimension']);
        $ods->setEliminado(false);

        $this->entityManager->persist($ods);
        $this->entityManager->flush();
    
        return new JsonResponse([
            'message' => 'ODS creado correctamente',
        ], Response::HTTP_CREATED);
    }

    // Función para actualizar un ODS
    public function updateOds(int $idOds, array $data): JsonResponse
    {
        $ods = $this->entityManager->getRepository(ODS::class)->find($idOds);

        if (!$ods) {
            return new JsonResponse([
                'message' => 'ODS no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        if (isset($data['nombre'])) {
            $ods->setNombre($data['nombre']);
        }

        if (isset($data['dimension'])) {
            $ods->setDimension($data['dimension']);
        }

        $this->entityManager->flush();

        return new JsonResponse([
            'message' => 'ODS actualizado correctamente',
        ], Response::HTTP_OK);
    }

    // Función para eliminar un ODS
    public function deleteOds(int $idOds): JsonResponse
    {
        $ods = $this->entityManager->getRepository(ODS::class)->find($idOds);

        if (!$ods) {
            return new JsonResponse(['message' => 'El ODS no ha sido encontrado'], Response::HTTP_NOT_FOUND);
        }

        if ($ods->isEliminado() == true) {
            return new JsonResponse(['message' => 'El ODS ya se encontraba eliminado'], Response::HTTP_BAD_REQUEST);
        }

        $ods->setEliminado(true);
        $this->entityManager->flush();
        return new JsonResponse(['message' => 'El ODS ha sido eliminado exitosamente'], Response::HTTP_OK);
    }

}