<?php

namespace App\Service;

use App\Entity\Clase;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Modulo;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;

class ModulosService{

    // Constructor con el manejador de entidades y el serializador
    public function __construct(private EntityManagerInterface $entityManager, private SerializerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    // Funcion para obtener todas las modulos
    public function getAllModulos(): JsonResponse
    {
        $modulos = $this->entityManager->getRepository(Modulo::class)->findAll();

        if ($modulos === null) {
            return new JsonResponse(['message' => 'No se han encontrado modulos'], JsonResponse::HTTP_NOT_FOUND);
        }

        $json = $this->serializer->serialize($modulos, 'json');
        return new JsonResponse($json, JsonResponse::HTTP_OK, [], true);
    }

    // Funcion para crear una Meta
    public function createModulo(array $data): JsonResponse
    {
        $modulo = new Modulo();

        $modulo->setNombre($data['nombre'] ?? null);
        if (!empty($data['clase']) && is_array($data['clase'])) {
            foreach ($data['clase'] as $clase) {
                $clase = $this->entityManager->getRepository(Clase::class)->find($clase);
                if ($clase !== null) {
                    $modulo->setClase($clase);
                }
            }
        }else{
            return new JsonResponse(['message' => 'Debes de introducir al menos una clase'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->flush();
    
        return new JsonResponse([
            'message' => 'Modulo creada correctamente',
        ], Response::HTTP_CREATED);
    }

    // Función para actualizar un Módulo
    public function updateModulo(int $id, array $data): JsonResponse
    {
        $modulo = $this->entityManager->getRepository(Modulo::class)->find($id);

        if (!$modulo) {
            return new JsonResponse([
                'message' => 'Módulo no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        if (isset($data['nombre'])) {
            $modulo->setNombre($data['nombre']);
        }

        if (!empty($data['clase']) && is_array($data['clase'])) {
            $claseEntities = [];
            foreach ($data['clase'] as $claseId) {
                $clase = $this->entityManager->getRepository(Clase::class)->find($claseId);
                if ($clase !== null) {
                    $claseEntities[] = $clase;
                }
            }

            if (!empty($claseEntities)) {
                // Suponiendo que setClase puede aceptar múltiples Clases relacionadas
                $modulo->setClase($claseEntities);
            } else {
                return new JsonResponse([
                    'message' => 'Debes de introducir al menos una clase válida',
                ], Response::HTTP_BAD_REQUEST);
            }
        }

        $this->entityManager->flush();

        return new JsonResponse([
            'message' => 'Módulo actualizado correctamente',
        ], Response::HTTP_OK);
    }

    // Función para eliminar un Módulo
    public function deleteModulo(int $id): JsonResponse
    {
        $modulo = $this->entityManager->getRepository(Modulo::class)->find($id);

        if (!$modulo) {
            return new JsonResponse([
                'message' => 'Módulo no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($modulo);
        $this->entityManager->flush();

        return new JsonResponse([
            'message' => 'Módulo eliminado correctamente',
        ], Response::HTTP_OK);
    }

}