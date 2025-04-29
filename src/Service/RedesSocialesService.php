<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\RedesSociales;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;

class RedesSocialesService{

    // Constructor con el manejador de entidades y el serializador
    public function __construct(private EntityManagerInterface $entityManager, private SerializerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    // Función para obtener todas las redes sociales
    public function getAllRedes(): JsonResponse
    {
        $redes = $this->entityManager->getRepository(RedesSociales::class)->findAll();

        if (empty($redes)) {
            return new JsonResponse(['message' => 'No se han encontrado redes sociales'], Response::HTTP_NOT_FOUND);
        }

        $json = $this->serializer->serialize($redes, 'json');
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    // Función para crear una red social
    public function createRedSocial(array $data): JsonResponse
    {
        if (!isset($data['nombre'])) {
            return new JsonResponse(['message' => 'El campo "nombre" es obligatorio'], Response::HTTP_BAD_REQUEST);
        }
        if(!isset($data['enlace'])){
            return new JsonResponse(['message' => 'El campo "enlace" es obligatorio'], Response::HTTP_BAD_REQUEST);
        }

        $redSocial = new RedesSociales();
        $redSocial->setNombre($data['nombre'] ?? null);
        $redSocial->setEnlace($data['enlace'] ?? null);
        $this->entityManager->persist($redSocial);
        $this->entityManager->flush();
    
        return new JsonResponse([
            'message' => 'Red Social creada correctamente',
        ], Response::HTTP_CREATED);
    }

    // Función para actualizar una red social
    public function updateRedSocial(int $idRedSocial, array $data): JsonResponse
    {
        $redSocial = $this->entityManager->getRepository(RedesSociales::class)->find($idRedSocial);

        if (!$redSocial) {
            return new JsonResponse([
                'message' => 'Red social no encontrada',
            ], Response::HTTP_NOT_FOUND);
        }

        if (isset($data['nombre'])) {
            $redSocial->setNombre($data['nombre']);
        }
        if (isset($data['enlace'])) {
            $redSocial->setEnlace($data['enlace']);
        }

        $this->entityManager->flush();

        return new JsonResponse([
            'message' => 'Red Social actualizada correctamente',
        ], Response::HTTP_OK);
    }

    // Función para eliminar una red social
    public function deleteRedSocial(int $idRedSocial): JsonResponse
    {
        $redSocial = $this->entityManager->getRepository(RedesSociales::class)->find($idRedSocial);

        if (!$redSocial) {
            return new JsonResponse(['message' => 'La Red Social no ha sido encontrada'], Response::HTTP_NOT_FOUND);
        }

        if ($redSocial->isEliminado() == true) {
            return new JsonResponse(['message' => 'La Red Social ya se encontraba eliminada'], Response::HTTP_BAD_REQUEST);
        }

        $redSocial->setEliminado(true);
        $this->entityManager->flush();
        return new JsonResponse(['message' => 'La Red Social ha sido eliminado exitosamente'], Response::HTTP_OK);
    }

}