<?php

namespace App\Service;

use App\Entity\Clase;
use App\Entity\Modulo;
use App\Entity\ModuloClase;
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

    // Obtener todas las clases
    public function getAllClases(): JsonResponse
    {
        $clases = $this->entityManager->getRepository(Clase::class)->findAll();

        if (empty($clases)) {
            return new JsonResponse(['message' => 'No se han encontrado clases'], Response::HTTP_NO_CONTENT);
        }

        $data = array_map(function ($clase) {
            return [
                'id' => $clase->getId(),
                'nombre' => $clase->getNombre(),
                'eliminado' => $clase->isEliminado(),
                'modulos' => array_map(function ($moduloClase) {
                    return[
                        'id' => $moduloClase->getModulo()->getId(),
                        'nombre' => $moduloClase->getModulo()->getNombre(),
                    ];
                }, $clase->getModuloClases()->toArray()),
            ];
        }, $clases);

        return new JsonResponse($data, Response::HTTP_OK, []);
    }

    // Crear una nueva clase
    public function createClase(array $data): JsonResponse
    {
        if (!isset($data['nombre'])) {
            return new JsonResponse(['message' => 'El campo "nombre" es obligatorio'], Response::HTTP_BAD_REQUEST);
        }

        $clase = new Clase();
        $clase->setNombre($data['nombre']);

        if (!empty($data['modulos']) && is_array($data['modulos'])) {
            $modulosRepo = $this->entityManager->getRepository(Modulo::class);
            foreach ($data['modulos'] as $moduloId) {
                $modulo = $modulosRepo->find($moduloId);
                if ($modulo) {
                    $moduloClase = new ModuloClase($modulo, $clase);
                    $clase->addModuloClase($moduloClase);
                    $this->entityManager->persist($moduloClase);
                }
            }
        } else {
            return new JsonResponse(['message' => 'Debes de introducir al menos un módulo'], Response::HTTP_NOT_FOUND);
        }

        $clase->setEliminado(false);

        $this->entityManager->persist($clase);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Clase creada correctamente'], Response::HTTP_CREATED);
    }

    // Actualizar una clase
    public function updateClase(int $idClase, array $data): JsonResponse
    {
        $clase = $this->entityManager->getRepository(Clase::class)->find($idClase);

        if (!$clase) {
            return new JsonResponse(['message' => 'Clase no encontrada'], Response::HTTP_NOT_FOUND);
        }

        if (!empty($data['nombre'])) {
            $clase->setNombre($data['nombre']);
        }

        if (!empty($data['modulos']) && is_array($data['modulos'])) {
            $modulosRepo = $this->entityManager->getRepository(Modulo::class);

            foreach ($clase->getModuloClases() as $moduloClases) {
                $this->entityManager->remove($moduloClases);
            }
            $this->entityManager->flush();

            foreach ($data['modulos'] as $moduloId) {
                $modulo = $modulosRepo->find($moduloId);
                if ($modulo) {
                    $moduloClase = new ModuloClase($modulo, $clase);
                    $clase->addModuloClase($moduloClase);
                    $this->entityManager->persist($moduloClase);
                }
            }
        } else {
            return new JsonResponse(['message' => 'Debes de introducir al menos una clase'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Clase actualizada correctamente'], Response::HTTP_OK);
    }

    // Eliminar una clase
    public function deleteClase(int $idClase): JsonResponse
    {
        $clase = $this->entityManager->getRepository(Clase::class)->find($idClase);

        if (!$clase) {
            return new JsonResponse(['message' => 'La Clase no ha sido encontrada'], Response::HTTP_NOT_FOUND);
        }

        if ($clase->isEliminado() == true) {
            return new JsonResponse(['message' => 'La Clase ya se encontraba eliminada'], Response::HTTP_BAD_REQUEST);
        }

        $clase->setEliminado(true);
        $this->entityManager->flush();
        return new JsonResponse(['message' => 'La Clase ha sido eliminado exitosamente'], Response::HTTP_OK);
    }
 
}