<?php

namespace App\Service;

use App\Repository\INICIATIVASRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class IniciativaService
{
    private INICIATIVASRepository $iniciativaRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager, INICIATIVASRepository $iniciativaRepository)
    {
        $this->entityManager = $entityManager;
        $this->iniciativaRepository = $iniciativaRepository;
    }

    public function getIniciativas(): JsonResponse
    {
        $iniciativas = $this->iniciativaRepository->findAll();

        if (!$iniciativas) {
            return new JsonResponse(['message' => 'No iniciatives found'], Response::HTTP_NOT_FOUND);
        }

        $data = array_map(fn($iniciativa) => $this->formatIniciativa($iniciativa), $iniciativas);

        return new JsonResponse($data);
    }

    public function getIniciativasEliminadas(): JsonResponse
    {
        $iniciativas = $this->iniciativaRepository->findByEliminado();
        
        if (!$iniciativas) {
            return new JsonResponse(['message' => 'No iniciatives found'], Response::HTTP_NOT_FOUND);
        }

        $data = array_map(fn($iniciativa) => $this->formatIniciativa($iniciativa), $iniciativas);

        return new JsonResponse($data);
    }

    public function getIniciativasActivas(): JsonResponse
    {
        $iniciativas = $this->iniciativaRepository->findByActivas();
        
        if (!$iniciativas) {
            return new JsonResponse(['message' => 'No iniciatives found'], Response::HTTP_NOT_FOUND);
        }

        $data = array_map(fn($iniciativa) => $this->formatIniciativa($iniciativa), $iniciativas);

        return new JsonResponse($data);
    }

    private function formatIniciativa($iniciativa): array
    {
        return [
            'id' => $iniciativa->getId(),
            'tipo' => $iniciativa->getTipo(),
            'horas' => $iniciativa->getHoras(),
            'nombre' => $iniciativa->getNombre(),
            'producto_final' => $iniciativa->getProductoFinal(),
            'fecha_registro' => $iniciativa->getFechaRegistro()->format('Y-m-d H:i:s'),
            'fecha_inicio' => $iniciativa->getFechaInicio()->format('Y-m-d H:i:s'),
            'fecha_fin' => $iniciativa->getFechaFin()->format('Y-m-d H:i:s'),
            'eliminado' => (bool) $iniciativa->isEliminado(),
            'innovador' => (bool) $iniciativa->isInnovador(),
            'imagen' => $iniciativa->getImagen(),
            'metas' => array_map(fn($metaIniciativa) => [
                'idMeta' => $metaIniciativa->getIdMetas()->getId(),
                'descripcion' => $metaIniciativa->getIdMetas()->getDescripcion(),
                'ods' => [
                    'idOds' => $metaIniciativa->getIdMetas()->getIdOds()->getId(),
                    'nombre' => $metaIniciativa->getIdMetas()->getIdOds()->getNombre(),
                    'dimension' => [
                        'idDimension' => $metaIniciativa->getIdMetas()->getIdOds()->getDimension()->getId(),
                        'nombre' => $metaIniciativa->getIdMetas()->getIdOds()->getDimension()->getNombre(),

                    ]
                ]
            ], $iniciativa->getMetasIniciativas()->toArray()),
            'profesores' => array_map(fn($profesorIniciativa) => [
                'idProfesor' => $profesorIniciativa->getProfesor()->getId(),
                'nombre' => $profesorIniciativa->getProfesor()->getNombre(),
            ], $iniciativa->getProfesores()->toArray()),
            'entidades_externas' => array_map(fn($entidadesExternasInciativa) => [
                'idEntidadExterna' => $entidadesExternasInciativa->getEntidad()->getId(),
                'nombre' => $entidadesExternasInciativa->getEntidad()->getNombre(),
            ], $iniciativa->getEntidadesExternas()->toArray()),
            'modulos' => array_map(fn($modulosIniciativas) => [
                'idModulo' => $modulosIniciativas->getModulo()->getId(),
                'nombre' => $modulosIniciativas->getModulo()->getNombre(),
                'curso' => [
                    'idCurso' => $modulosIniciativas->getModulo()->getCurso()->getId(),
                    'nombre' => $modulosIniciativas->getModulo()->getCurso()->getNombre(),
                ],
            ], $iniciativa->getModulos()->toArray()),

        ];
    }
}
