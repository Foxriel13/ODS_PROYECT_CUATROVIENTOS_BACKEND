<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Meta;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\ODS;

class MetasService{

    // Constructor con el manejador de entidades y el serializador
    public function __construct(private EntityManagerInterface $entityManager, private SerializerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    // Función para obtener todas las metas
    public function getAllMetas(): JsonResponse
    {
        $metas = $this->entityManager->getRepository(Meta::class)->findAll();

        if (empty($metas)) {
            return new JsonResponse(['message' => 'No se han encontrado metas'], Response::HTTP_NO_CONTENT);
        }

        $json = $this->serializer->serialize($metas, 'json');
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    // Obtener una meta por ID
    private function getMetaById(int $id): ?Meta
    {
        return $this->entityManager->getRepository(Meta::class)->find($id);
    }

    // Función para crear una Meta
    public function createMeta(array $data): JsonResponse
    {
        if (empty($data['descripcion'])) {
            return new JsonResponse(['message' => 'La descripción es obligatoria'], Response::HTTP_BAD_REQUEST);
        }

        if (empty($data['ods']) || !is_array($data['ods'])) {
            return new JsonResponse(['message' => 'Debes de introducir al menos un ODS válido'], Response::HTTP_BAD_REQUEST);
        }

        $meta = new Meta();
        $meta->setDescripcion($data['descripcion']);

        foreach ($data['ods'] as $odsId) {
            $ods = $this->entityManager->getRepository(ODS::class)->find($odsId);
            if ($ods !== null) {
                $meta->setOds($ods);
            }
        }

        $this->entityManager->persist($meta);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Meta creada correctamente'], Response::HTTP_CREATED);
    }

    // Función para actualizar una Meta
    public function updateMeta(int $id, array $data): JsonResponse
    {
        $meta = $this->getMetaById($id);

        if (!$meta) {
            return new JsonResponse(['message' => 'Meta no encontrada'], Response::HTTP_NOT_FOUND);
        }

        if (!isset($data['descripcion'])) {
            return new JsonResponse(['message' => 'El campo "nombre" es obligatorio'], Response::HTTP_BAD_REQUEST);
        }
        $meta->setDescripcion($data['descripcion']);

        if (!empty($data['ods']) && is_array($data['ods'])) {
            $odsEntities = [];
            foreach ($data['ods'] as $odsId) {
                $ods = $this->entityManager->getRepository(ODS::class)->find($odsId);
                if ($ods !== null) {
                    $odsEntities[] = $ods;
                }
            }

            if (!empty($odsEntities)) {
                foreach ($odsEntities as $ods) {
                    $meta->setOds($ods);
                }
            } else {
                return new JsonResponse(['message' => 'Debes de introducir al menos un ODS válido'], Response::HTTP_BAD_REQUEST);
            }
        }

        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Meta actualizada correctamente'], Response::HTTP_OK);
    }

    // Función para eliminar una Meta
    public function deleteMeta(int $id): JsonResponse
    {
        $meta = $this->getMetaById($id);

        if (!$meta) {
            return new JsonResponse(['message' => 'Meta no encontrada'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($meta);
        $this->entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

}