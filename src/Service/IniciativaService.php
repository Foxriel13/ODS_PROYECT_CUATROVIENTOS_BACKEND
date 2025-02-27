<?php

namespace App\Service;

use App\Repository\RecipeRepository;
use App\Entity\CURSOS;
use App\Entity\DIMENSION;
use App\Entity\ENTIDADESEXTERNAS;
use App\Entity\ENTIDADESEXTERNASINICIATIVAS;
use App\Entity\INICIATIVAS;
use App\Entity\INICIATIVASMODULOS;
use App\Entity\METAS;
use App\Entity\METASINICIATIVAS;
use App\Entity\MODULOS;
use App\Entity\ODS;
use App\Entity\PROFESORES;
use App\Entity\PROFESORESINICIATIVAS;
use App\Entity\PROFESORESMODULOS;
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
    private function formatIniciativa($iniciativa): array
    {
        return [
            'id' => $iniciativa->getId(),
            'accion' => $iniciativa->getAccion(),
            'horas' => $iniciativa->getHoras(),
            'nombre' => $iniciativa->getNombre(),
            'producto_final' => $iniciativa->getProductoFinal(),
            'fecha_inicio' => $iniciativa->getFechaInicio()->format('Y-m-d H:i:s'),
            'fecha_fin' => $iniciativa->getFechaFin()->format('Y-m-d H:i:s'),
            'eliminado' => (bool) $iniciativa->isEliminado(),
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