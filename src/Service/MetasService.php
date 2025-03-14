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

    // Funcion para obtener todas las metas
    public function getAllMetas(): JsonResponse
    {
        $metas = $this->entityManager->getRepository(Meta::class)->findAll();

        if ($metas === null) {
            return new JsonResponse(['message' => 'No se han encontrado metas'], JsonResponse::HTTP_NOT_FOUND);
        }

        $json = $this->serializer->serialize($metas, 'json');
        return new JsonResponse($json, JsonResponse::HTTP_OK, [], true);
    }

    // Funcion para crear una Entidad Externa
    public function createMeta(array $data): JsonResponse
    {
        $meta = new Meta();

        $meta->setDescripcion($data['descripcion'] ?? null);
        if (!empty($data['ods']) && is_array($data['ods'])) {
            foreach ($data['ods'] as $ods) {
                $ods = $this->entityManager->getRepository(ODS::class)->find($ods);
                if ($ods !== null) {
                    $meta->setIdOds($ods);
                }
            }
        }else{
            return new JsonResponse(['message' => 'Debes de introducir al menos un ods'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->persist($meta);
        $this->entityManager->flush();
    
        return new JsonResponse([
            'message' => 'Meta creada correctamente',
        ], Response::HTTP_CREATED);
    }

    // Función para actualizar una Meta
    public function updateMeta(int $id, array $data): JsonResponse
    {
        $meta = $this->entityManager->getRepository(Meta::class)->find($id);

        if (!$meta) {
            return new JsonResponse([
                'message' => 'Meta no encontrada',
            ], Response::HTTP_NOT_FOUND);
        }

        if (isset($data['descripcion'])) {
            $meta->setDescripcion($data['descripcion']);
        }

        if (!empty($data['ods']) && is_array($data['ods'])) {
            $odsEntities = [];
            foreach ($data['ods'] as $odsId) {
                $ods = $this->entityManager->getRepository(ODS::class)->find($odsId);
                if ($ods !== null) {
                    $odsEntities[] = $ods;
                }
            }

            if (!empty($odsEntities)) {
                // Suponiendo que setIdOds puede aceptar múltiples ODS relacionados
                $meta->setIdOds($odsEntities);
            } else {
                return new JsonResponse([
                    'message' => 'Debes de introducir al menos un ODS válido',
                ], Response::HTTP_BAD_REQUEST);
            }
        }

        $this->entityManager->flush();

        return new JsonResponse([
            'message' => 'Meta actualizada correctamente',
        ], Response::HTTP_OK);
    }

    // Función para eliminar una Meta
    public function deleteMeta(int $id): JsonResponse
    {
        $meta = $this->entityManager->getRepository(Meta::class)->find($id);

        if (!$meta) {
            return new JsonResponse([
                'message' => 'Meta no encontrada',
            ], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($meta);
        $this->entityManager->flush();

        return new JsonResponse([
            'message' => 'Meta eliminada correctamente',
        ], Response::HTTP_OK);
    }

}