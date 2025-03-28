<?php

namespace App\Service;


use App\Entity\Iniciativa;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class IndicadoresService
{
    // Constructor con el manejador de entidades
    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // GET Indicador 1
    public function getIniciativasPorCurso(int $id): JsonResponse
    {
        $iniciativas = $this->entityManager->getRepository(Iniciativa::class)->findByCurso($id);

        if (!$iniciativas) {
            return new JsonResponse(['message' => 'No se han encontrado iniciativas'], Response::HTTP_NOT_FOUND);
        }

        $data = array_map(fn($iniciativa) => $this->formatIniciativa($iniciativa), $iniciativas);

        return new JsonResponse($data);
    }

    // GET Indicador 2
    public function getNumeroIniciativas(): JsonResponse
    {
        $iniciativas = $this->entityManager->getRepository(Iniciativa::class)->findAll();

        if (!$iniciativas) {
            return new JsonResponse(['message' => 'No se han encontrado iniciativas'], Response::HTTP_NOT_FOUND);
        }

        $data = count($iniciativas);

        return new JsonResponse($data);
    }

    // GET Indicador 4
    public function getDescripcionIniciativa(): JsonResponse
    {
        $iniciativas = $this->entityManager->getRepository(Iniciativa::class)->findAll();
    
        if (!$iniciativas) {
            return new JsonResponse(['message' => 'No se han encontrado iniciativas'], Response::HTTP_NOT_FOUND);
        }
    
        $data = [];
        foreach ($iniciativas as $iniciativa) {
            $data[] = $iniciativa->getExplicacion();
        }
    
        return new JsonResponse($data);
    }
    


    // GET Indicador 6
    public function getHaColaboradoEntidadExterna(int $id): JsonResponse
    {
        $iniciativa = $this->entityManager->getRepository(Iniciativa::class)->findById($id);

        if (!$iniciativa) {
            return new JsonResponse(['message' => 'No se han encontrado iniciativas'], Response::HTTP_NOT_FOUND);
        }

        $entidadesExternas = $iniciativa->getEntidadesExternas();

        if (count($entidadesExternas) == 0) {
            $data = false;
        }else{
            $data = true;
        }

        return new JsonResponse($data);
    }

    // GET Indicador 7
    public function getRedesSociales(int $id): JsonResponse
    {
        $iniciativa = $this->entityManager->getRepository(Iniciativa::class)->findById($id);

        if (!$iniciativa) {
            return new JsonResponse(['message' => 'No se han encontrado iniciativas'], Response::HTTP_NOT_FOUND);
        }

        $redesSociales = $iniciativa->getIniciativaRedesSociales();

        if (count($redesSociales) == 0) {
            return new JsonResponse(['message' => "La iniciativa con id $id no tiene Redes Sociales"], Response::HTTP_NOT_FOUND);
        }else{
            $data = $redesSociales;
        }

        return new JsonResponse($data);
    }

    // GET Indicador 8
    public function getTipo(int $id): JsonResponse
    {
        $iniciativa = $this->entityManager->getRepository(Iniciativa::class)->findById($id);

        if (!$iniciativa) {
            return new JsonResponse(['message' => 'No se han encontrado iniciativas'], Response::HTTP_NOT_FOUND);
        }

        $redesSociales = $iniciativa->getTipo();

        if (count($redesSociales) == 0) {
            return new JsonResponse(['message' => "La iniciativa con id $id no tiene Redes Sociales"], Response::HTTP_NOT_FOUND);
        }else{
            $data = $redesSociales;
        }

        return new JsonResponse($data);
    }

    private function formatIniciativa($iniciativa): array
    {
        return [
            'id' => $iniciativa->getId(),
            'tipo' => $iniciativa->getTipo(),
            'horas' => $iniciativa->getHoras(),
            'nombre' => $iniciativa->getNombre(),
            'explicacion' => $iniciativa->getExplicacion(),
            'fecha_inicio' => $iniciativa->getFechaInicio()->format('Y-m-d H:i:s'),
            'fecha_fin' => $iniciativa->getFechaFin()->format('Y-m-d H:i:s'),
            'eliminado' => (bool) $iniciativa->isEliminado(),
            'innovador' => (bool) $iniciativa->isInnovador(),
            'anyo_lectivo' => $iniciativa->getAnyoLectivo(),
            'imagen' => $iniciativa->getImagen(),
            'fecha_registro' => $iniciativa->getFechaRegistro()->format('Y-m-d H:i:s'),
            'mas_comentarios' => $iniciativa->getMasComentarios(),
            'metas' => array_map(fn($metaIniciativa) => [
                'idMeta' => $metaIniciativa->getIdMetas()->getId(),
                'descripcion' => $metaIniciativa->getIdMetas()->getDescripcion(),
                'ods' => [
                    'idOds' => $metaIniciativa->getIdMetas()->getOds()->getId(),
                    'nombre' => $metaIniciativa->getIdMetas()->getOds()->getNombre(),
                    'dimension' => $metaIniciativa->getIdMetas()->getOds()->getDimension()
                ],
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
                'clase' => [
                    'idClase' => $modulosIniciativas->getModulo()->getClase()->getId(),
                    'nombre' => $modulosIniciativas->getModulo()->getClase()->getNombre(),
                ],
            ], $iniciativa->getModulos()->toArray()),
            'redes_sociales' => array_map(fn($iniciativaRedSocial) => [
                'idRedSocial' => $iniciativaRedSocial->getRedesSociales()->getId(),
                'nombre' => $iniciativaRedSocial->getRedesSociales()->getNombre(),
                'enlace' => $iniciativaRedSocial->getRedesSociales()->getEnlace(),
            ], $iniciativa->getIniciativaRedesSociales()->toArray()),
        ];
    }

}
