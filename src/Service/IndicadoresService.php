<?php

namespace App\Service;


use App\Entity\Iniciativa;
use App\Entity\Profesor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\IniciativaRepository;


class IndicadoresService
{
    // Constructor con el manejador de entidades
    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // GET Indicador 1: Done
    public function getIniciativasPorCurso(): JsonResponse
    {
        $aniosLectivos =  $this->entityManager->getRepository(Iniciativa::class)->findAniosLectivos();
        $conteoIniciativas =  $this->entityManager->getRepository(Iniciativa::class)->countIniciativasPorAnio();

        $resultado = [];
        foreach ($aniosLectivos as $anyoLectivo) {
            $totalIniciativas = 0;
            foreach ($conteoIniciativas as $conteo) {
                if ($conteo['anyoLectivo'] === $anyoLectivo) {
                    $totalIniciativas = $conteo['total'];
                    break;
                }
            }

            $resultado[] = [
                'nombreCurso' => $anyoLectivo,
                'numIniciativas' => $totalIniciativas
            ];
        }

        return new JsonResponse($resultado);
    }

    // GET Indicador 2: Done
    public function getNumeroIniciativas(): JsonResponse
    {
        $iniciativas = $this->entityManager->getRepository(Iniciativa::class)->findAll();

        if (!$iniciativas) {
            return new JsonResponse(['message' => 'No se han encontrado iniciativas'], Response::HTTP_NOT_FOUND);
        }

        $data = [
            'cantidad' => count($iniciativas)
        ];

        return new JsonResponse($data);
    }

    //GET Indicador 3: Por revisar
    public function getCiclosYModulosConIniciativas(): JsonResponse
    {
        $datos = $this->entityManager->getRepository(Iniciativa::class)->getIniciativasConCiclosYModulos();
        
        $resultado = [];

        foreach ($datos as $dato) {
            $iniciativaId = $dato['iniciativa_id'];
            $cicloId = $dato['ciclo_id'];
            $moduloId = $dato['modulo_id'];

            if (!isset($resultado[$iniciativaId])) {
                $resultado[$iniciativaId] = [
                    'id' => $iniciativaId,
                    'nombre_iniciativa' => $dato['iniciativa_nombre'],
                    'ciclos' => []
                ];
            }

            if (!isset($resultado[$iniciativaId]['ciclos'][$cicloId])) {
                $resultado[$iniciativaId]['ciclos'][$cicloId] = [
                    'id_ciclo' => $cicloId,
                    'nombre_ciclo' => $dato['ciclo_nombre'],
                    'modulos' => []
                ];
            }

            $resultado[$iniciativaId]['ciclos'][$cicloId]['modulos'][] = [
                'id_modulo' => $moduloId,
                'nombre_modulo' => $dato['modulo_nombre']
            ];
        }

        foreach ($resultado as &$iniciativa) {
            $iniciativa['ciclos'] = array_values($iniciativa['ciclos']);
        }

        return new JsonResponse(array_values($resultado));
    }

    // GET Indicador 4: Done
    public function getDescripcionIniciativa(): JsonResponse
    {
        $iniciativas = $this->entityManager->getRepository(Iniciativa::class)->findAll();

        if (!$iniciativas) {
            return new JsonResponse(['message' => 'No se han encontrado iniciativas'], Response::HTTP_NOT_FOUND);
        }

        $data = [];
        foreach ($iniciativas as $iniciativa) {
            $data[] = [
                'Nombre' => $iniciativa->getNombre(),
                'Explicacion' => $iniciativa->getExplicacion()
            ];
        }

        return new JsonResponse($data);
    }

    // GET Indicador 5: Por revisar
    public function getODStrabajadosYSusMetas(): JsonResponse
    {
        $datos = $this->entityManager->getRepository(Iniciativa::class)->getODStrabajadosYSusMetas();
        
        $resultado = [];

        foreach ($datos as $dato) {
            $iniciativaId = $dato['iniciativa_id'];
            $odsId = $dato['ods_id'];
            $metaId = $dato['meta_id'];

            if (!isset($resultado[$iniciativaId])) {
                $resultado[$iniciativaId] = [
                    'id' => $iniciativaId,
                    'nombre_Iniciativa' => $dato['iniciativa_nombre'],
                    'ods' => []
                ];
            }

            if (!isset($resultado[$iniciativaId]['ods'][$odsId])) {
                $resultado[$iniciativaId]['ods'][$odsId] = [
                    'id_ods' => $odsId,
                    'nombre_ods' => $dato['ods_nombre'],
                    'metas' => []
                ];
            }

            $resultado[$iniciativaId]['ods'][$odsId]['metas'][] = [
                'id_meta' => $metaId,
                'nombre_meta' => $dato['meta_nombre']
            ];
        }

        foreach ($resultado as &$iniciativa) {
            $iniciativa['ods'] = array_values($iniciativa['ods']);
        }

        return new JsonResponse(array_values($resultado));
    }

    // GET Indicador 6: Done
    public function getTieneEntidadesExternas(): JsonResponse
    {
        $iniciativas = $this->entityManager->getRepository(Iniciativa::class)->findAll();

        if (!$iniciativas) {
            return new JsonResponse(['message' => 'No se han encontrado iniciativas'], Response::HTTP_NOT_FOUND);
        }
        $tiene = 0;
        $notiene = 0;
        foreach ($iniciativas as $iniciativa) {
            $entidadesExternas = $iniciativa->getEntidadesExternas();
            if (count($entidadesExternas) == 0) {
                $notiene += 1;
            } else {
                $tiene += 1;
            }
        }

        $data[] = [
            'tiene_entidades' => $tiene,
            'no_tiene_entidades' => $notiene
        ];

        return new JsonResponse($data);
    }

    // GET Indicador 7: Done
    public function getRRSSdeIniciativa(): JsonResponse
    {
        $iniciativas = $this->entityManager->getRepository(Iniciativa::class)->findAll();
    
        if (!$iniciativas) {
            return new JsonResponse(['message' => 'No se han encontrado iniciativas'], Response::HTTP_NOT_FOUND);
        }
    
        $data = [];
    
        foreach ($iniciativas as $iniciativa) {
            $iniciativaRedesSociales = $iniciativa->getIniciativaRedesSociales();
    
            if (count($iniciativaRedesSociales) > 0) {
                foreach ($iniciativaRedesSociales as $iniciativaRedSocial) {
                    $redSocial = $iniciativaRedSocial->getRedesSociales();
    
                    $data[] = [
                        'nombre_iniciativa' => $iniciativa->getNombre(),
                        'redes_sociales'    => [
                            "nombreRRSS" => $redSocial->getNombre(),
                            "enlace" => $redSocial->getEnlace(),
                        ],
                    ];
                }
            }
        }
    
        if (empty($data)) {
            return new JsonResponse(['message' => 'No hay iniciativas difundidas'], Response::HTTP_NOT_FOUND);
        }
    
        return new JsonResponse($data);
    }

    // GET Indicador 8: Por revisar
    public function getTiposIniciativas(): JsonResponse
    {
        // Se obtiene el repositorio y se llama a la función countByTipo
        $resultados = $this->entityManager->getRepository(Iniciativa::class)->countByTipo();

        if (!$resultados) {
            return new JsonResponse(['message' => 'No se han encontrado iniciativas'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($resultados);
    }

    //GET indicador 10.1: Done
    public function getCantidadProfesores(): JsonResponse
    {
        $profesores = $this->entityManager->getRepository(Profesor::class)->findAll();

        if (!$profesores) {
            return new JsonResponse(['message' => 'No se han encontrado profesores'], Response::HTTP_NOT_FOUND);
        }

        $data = [
            'cantidad' => count($profesores)
        ];
        return new JsonResponse($data);
    }

    //GET indicador 10.2: Por revisar
    public function getCantidadDeIniciativasPorProfesor(): array
    {
        $profesores = $this->entityManager->getRepository(Profesor::class)->countIniciativasPorProfesor();

        if (!$profesores) {
            return new JsonResponse(['message' => 'No se han encontrado profesores'], Response::HTTP_NOT_FOUND);
        }

        return array_map(fn($profesor) => [
            'nombre_profesor' => $profesor['nombre'],
            'cantDeIniciativas' => (int) $profesor['totalIniciativas'] // Aseguramos que sea número entero
        ], $profesores);
    }

    //GET indicador 11: Done
    public function getDiferenciaInnovadoras(): JsonResponse
    {
        $innovadoras = $this->entityManager->getRepository(Iniciativa::class)->findByInnovadoras();
        $noInnovadoras = $this->entityManager->getRepository(Iniciativa::class)->findByNoInnovadoras();
        
        if(!$innovadoras && !$noInnovadoras){
            return new JsonResponse(['message' => 'No se han encontrado iniciativas'], Response::HTTP_NOT_FOUND);
        }

        $data = [
            'cantidad_innovadoras' => count($innovadoras),
            'cantidad_no_innovadores' => count($noInnovadoras)
        ];
        return new JsonResponse($data);
    }

    //GET indicador 12: Done
    public function getHorasActividad(): JsonResponse
    {
        $iniciativas = $this->entityManager->getRepository(Iniciativa::class)->findAll();
        $data = [];
        if(!$iniciativas){
            return new JsonResponse(['message' => 'No se han encontrado iniciativas'], Response::HTTP_NOT_FOUND);
        }
        foreach ($iniciativas as $iniciativa) {
            $data[] = [
                'nombre_iniciativa' => $iniciativa->getNombre(),
                'horas_dedicadas' => $iniciativa->getHoras()
            ];
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
