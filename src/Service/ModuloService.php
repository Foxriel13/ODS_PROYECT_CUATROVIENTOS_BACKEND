<?php

namespace App\Service;

use App\Entity\Clase;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Modulo;
use App\Entity\ModuloClase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;

class ModuloService
{

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

        $data = array_merge(...array_map(fn($modulo) => $this->formatModulo($modulo), $modulos));
        return new JsonResponse($data);
    }

    // Función para crear un Módulo
    public function createModulo(array $data): JsonResponse
    {
        if (empty($data['nombre'])) {
            return new JsonResponse(['message' => 'El nombre es obligatorio'], Response::HTTP_BAD_REQUEST);
        }

        $modulo = new Modulo();
        $modulo->setNombre($data['nombre'] ?? null);

        if (!empty($data['clases']) && is_array($data['clases'])) {
            $clasesRepo = $this->entityManager->getRepository(Clase::class);
            foreach ($data['clases'] as $claseId) {
                $clase = $clasesRepo->find($claseId);
                if ($clase) {
                    $moduloClase = new ModuloClase($modulo, $clase);
                    $modulo->addModuloClase($moduloClase);
                    $this->entityManager->persist($moduloClase);
                }
            }
        } else {
            return new JsonResponse(['message' => 'Debes de introducir al menos una clase'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->persist($modulo);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Módulo creado correctamente'], Response::HTTP_CREATED);
    }

    public function updateModulo(int $idModulo, array $data): JsonResponse
    {
        $modulo = $this->entityManager->getRepository(Modulo::class)->find($idModulo);

        if (!$modulo) {
            return new JsonResponse(['message' => 'Módulo no encontrado'], Response::HTTP_NOT_FOUND);
        }

        if (isset($data['nombre'])) {
            $modulo->setNombre($data['nombre']);
        }

        // Actualizar clases
        if (!empty($data['clases']) && is_array($data['clases'])) {
            // Eliminar relaciones anteriores
            foreach ($modulo->getModuloClases() as $moduloClase) {
                $this->entityManager->remove($moduloClase);
            }

            // Añadir nuevas relaciones
            $clasesRepo = $this->entityManager->getRepository(Clase::class);
            foreach ($data['clases'] as $idClase) {
                $clase = $clasesRepo->find($idClase);
                if ($clase) {
                    $moduloClase = new ModuloClase($modulo, $clase);
                    $modulo->addModuloClase($moduloClase);
                    $this->entityManager->persist($moduloClase);
                }
            }
        }

        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Módulo actualizado correctamente'], Response::HTTP_OK);
    }


    // Función para eliminar un Módulo
    public function deleteModulo(int $idModulo): JsonResponse
    {
        $modulo = $this->entityManager->getRepository(Modulo::class)->find($idModulo);

        if (!$modulo) {
            return new JsonResponse(['message' => 'Módulo no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($modulo);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Módulo eliminado correctamente'], Response::HTTP_OK);
    }

    private function formatModulo($modulo): array
    {
        return array_map(fn($iniciativaModulo) => [
            'idModulo' => $iniciativaModulo->getModulo()->getId(),
            'nombre' => $iniciativaModulo->getModulo()->getNombre(),
            'clases' => array_map(fn($modulosClase) => [
                'idClase' => $modulosClase->getClase()->getId(),
                'nombre' => $modulosClase->getClase()->getNombre(),
            ], $iniciativaModulo->getModulo()->getModuloClases()->toArray()),
        ], $modulo->getModuloClases()->toArray());
    }

}
