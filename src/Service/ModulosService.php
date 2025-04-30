<?php

namespace App\Service;

use App\Entity\Clase;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Modulo;
use App\Entity\ModuloClase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;

class ModulosService
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
        $modulo->setEliminado(false);

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

        if (isset($data['eliminado'])) {
            $modulo->setEliminado($data['eliminado']);
        }

        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Módulo actualizado correctamente'], Response::HTTP_OK);
    }

    // Función para eliminar un Módulo
    public function deleteModulo(int $idModulo): JsonResponse
    {
        $modulo = $this->entityManager->getRepository(Modulo::class)->find($idModulo);

        if (!$modulo) {
            return new JsonResponse(['message' => 'El módulo no ha sido encontrado'], Response::HTTP_NOT_FOUND);
        }

        if ($modulo->isEliminado() == true) {
            return new JsonResponse(['message' => 'El módulo ya se encontraba eliminado'], Response::HTTP_BAD_REQUEST);
        }

        $modulo->setEliminado(true);
        $this->entityManager->flush();
        return new JsonResponse(['message' => 'El módulo ha sido eliminado exitosamente'], Response::HTTP_OK);
    }

    private function formatModulo($modulo): array
    {
        $modulos = array_map(fn($iniciativaModulo) => [
            'idModulo' => $iniciativaModulo->getModulo()->getId(),
            'nombre' => $iniciativaModulo->getModulo()->getNombre(),
        ], $modulo->getModuloClases()->toArray());
    
        // Eliminar duplicados por 'idModulo'
        $unicos = [];
        $ids = [];
    
        foreach ($modulos as $modulo) {
            if (!in_array($modulo['idModulo'], $ids)) {
                $ids[] = $modulo['idModulo'];
                $unicos[] = $modulo;
            }
        }
    
        return $unicos;
    }
    
}
