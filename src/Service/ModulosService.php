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

    // Función para obtener todos los módulos
    public function getAllModulos(): JsonResponse
    {
        $modulos = $this->entityManager->getRepository(Modulo::class)->findAll();

        if (empty($modulos)) {
            return new JsonResponse(['message' => 'No se han encontrado módulos'], Response::HTTP_NOT_FOUND);
        }

        $json = $this->serializer->serialize($modulos, 'json');
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    // Función para crear un Módulo
    public function createModulo(array $data): JsonResponse
    {
        $modulo = new Modulo();

        $modulo->setNombre($data['nombre'] ?? null);

        // Validación de clases
        if (!empty($data['clase']) && is_array($data['clase'])) {
            foreach ($data['clase'] as $claseId) {
                $clase = $this->entityManager->getRepository(Clase::class)->find($claseId);
                if ($clase !== null) {
                    $modulo->setClase($clase);
                }
            }
        } else {
            return new JsonResponse(['message' => 'Debes de introducir al menos una clase'], Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->persist($modulo);
        $this->entityManager->flush();
    
        return new JsonResponse(['message' => 'Módulo creado correctamente'], Response::HTTP_CREATED);
    }

    // Función para actualizar un Módulo
    public function updateModulo(int $id, array $data): JsonResponse
    {
        $modulo = $this->entityManager->getRepository(Modulo::class)->find($id);

        if (!$modulo) {
            return new JsonResponse(['message' => 'Módulo no encontrado'], Response::HTTP_NOT_FOUND);
        }

        if (isset($data['nombre'])) {
            $modulo->setNombre($data['nombre']);
        }

        // Actualización de clases
        if (!empty($data['clase']) && is_array($data['clase'])) {
            $claseEntities = [];
            foreach ($data['clase'] as $claseId) {
                $clase = $this->entityManager->getRepository(Clase::class)->find($claseId);
                if ($clase !== null) {
                    $claseEntities[] = $clase;
                }
            }

            if (!empty($claseEntities)) {
                foreach ($claseEntities as $clase) {
                    $modulo->addClase($clase);
                }
            } else {
                return new JsonResponse(['message' => 'Debes de introducir al menos una clase válida'], Response::HTTP_BAD_REQUEST);
            }
        }

        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Módulo actualizado correctamente'], Response::HTTP_OK);
    }

    // Función para eliminar un Módulo
    public function deleteModulo(int $id): JsonResponse
    {
        $modulo = $this->entityManager->getRepository(Modulo::class)->find($id);

        if (!$modulo) {
            return new JsonResponse(['message' => 'Módulo no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($modulo);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Módulo eliminado correctamente'], Response::HTTP_OK);
    }

}