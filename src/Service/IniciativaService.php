<?php

namespace App\Service;

use App\Entity\ENTIDADESEXTERNAS;
use App\Entity\ENTIDADESEXTERNASINICIATIVAS;
use App\Entity\INICIATIVAS;
use App\Entity\INICIATIVASMODULOS;
use App\Entity\METAS;
use App\Entity\METASINICIATIVAS;
use App\Entity\MODULOS;
use App\Entity\PROFESORES;
use App\Entity\PROFESORESINICIATIVAS;
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

    public function deleteIniciativa(int $id): JsonResponse
    {
        $iniciativa = $this->iniciativaRepository->find($id);
        
        if (!$iniciativa) {
            return new JsonResponse(['message' => 'Iniciativa no encontrada'], Response::HTTP_NOT_FOUND);
        }
        
        $iniciativa->setEliminado(true);
        
        $this->entityManager->flush();
        
        return new JsonResponse(['message' => 'Iniciativa eliminada exitosamente'], Response::HTTP_OK);
    }

    public function createIniciativa(array $data): JsonResponse
    {
        $iniciativa = new INICIATIVAS();
        
        $iniciativa->setTipo($data['tipo'] ?? null);
        $iniciativa->setHoras($data['horas'] ?? null);
        $iniciativa->setNombre($data['nombre'] ?? null);
        $iniciativa->setExplicacion($data['explicacion'] ?? null);
        
        if (isset($data['fecha_registro'])) {
            $iniciativa->setFechaRegistro(new \DateTime($data['fecha_registro']));
        }
        if (isset($data['fecha_inicio'])) {
            $iniciativa->setFechaInicio(new \DateTime($data['fecha_inicio']));
        }
        if (isset($data['fecha_fin'])) {
            $iniciativa->setFechaFin(new \DateTime($data['fecha_fin']));
        }
        
        $iniciativa->setEliminado(false);
        $iniciativa->setInnovador($data['innovador'] ?? false);
        $iniciativa->setAnyoLectivo($data['anyo_lectivo'] ?? null);
        $iniciativa->setImagen($data['imagen'] ?? null);

        if (!empty($data['metas']) && is_array($data['metas'])) {
            $metasRepo = $this->entityManager->getRepository(METAS::class);
            foreach ($data['metas'] as $metaId) {
                $meta = $metasRepo->find($metaId);
                if ($meta) {
                    $iniciativaMeta = new METASINICIATIVAS($iniciativa, $meta);
                    $iniciativa->addMetasIniciativa($iniciativaMeta);
                    $this->entityManager->persist($iniciativaMeta);
                }
            }
        }

        if (!empty($data['profesores']) && is_array($data['profesores'])) {
            $profesorRepo = $this->entityManager->getRepository(PROFESORES::class);
            foreach ($data['profesores'] as $profesorId) {
                $profesor = $profesorRepo->find($profesorId);
                if ($profesor) {
                    $iniciativaProfesor = new PROFESORESINICIATIVAS($iniciativa, $profesor);
                    $iniciativa->addProfesor($iniciativaProfesor);
                    $this->entityManager->persist($iniciativaProfesor);
                }
            }
        }

        if (!empty($data['entidades_externas']) && is_array($data['entidades_externas'])) {
            $entidadesExternasRepo = $this->entityManager->getRepository(ENTIDADESEXTERNAS::class);
            foreach ($data['entidades_externas'] as $entidadExternaId) {
                $entidadExterna = $entidadesExternasRepo->find($entidadExternaId);
                if ($entidadExterna) {
                    $iniciativaEntidadExterna = new ENTIDADESEXTERNASINICIATIVAS($iniciativa, $entidadExterna);
                    $iniciativa->addEntidadesExterna($iniciativaEntidadExterna);
                    $this->entityManager->persist($iniciativaEntidadExterna);
                }
            }
        }

        if (!empty($data['modulos']) && is_array($data['modulos'])) {
            $modulosRepo = $this->entityManager->getRepository(MODULOS::class);
            foreach ($data['modulos'] as $moduloId) {
                $modulo = $modulosRepo->find($moduloId);
                if ($entidadExterna) {
                    $iniciativaModulo = new INICIATIVASMODULOS($iniciativa, $modulo);
                    $iniciativa->addModulo($iniciativaModulo);
                    $this->entityManager->persist($iniciativaModulo);
                }
            }
        }

        $this->entityManager->persist($iniciativa);
        $this->entityManager->flush();

        return new JsonResponse([
            'message' => 'Iniciativa creada correctamente',
        ], Response::HTTP_CREATED);
    }

    public function updateIniciativa(int $id, array $data): JsonResponse
    {
        $iniciativa = $this->iniciativaRepository->find($id);
        if (!$iniciativa) {
            return new JsonResponse(['message' => 'Iniciativa no encontrada'], Response::HTTP_NOT_FOUND);
        }

        if (isset($data['tipo'])) {
            $iniciativa->setTipo($data['tipo']);
        }
        if (isset($data['horas'])) {
            $iniciativa->setHoras($data['horas']);
        }
        if (isset($data['nombre'])) {
            $iniciativa->setNombre($data['nombre']);
        }
        if (isset($data['producto_final'])) {
            $iniciativa->setProductoFinal($data['producto_final']);
        }
        if (isset($data['fecha_inicio'])) {
            $iniciativa->setFechaInicio(new \DateTime($data['fecha_inicio']));
        }
        if (isset($data['fecha_fin'])) {
            $iniciativa->setFechaFin(new \DateTime($data['fecha_fin']));
        }
        if (isset($data['eliminado'])) {
            $iniciativa->setEliminado($data['eliminado']);
        }
        if (isset($data['innovador'])) {
            $iniciativa->setInnovador($data['innovador']);
        }
        if (isset($data['anyo_lectivo'])) {
            $iniciativa->setAnyoLectivo($data['anyo_lectivo']);
        }
        if (isset($data['imagen'])) {
            $iniciativa->setImagen($data['imagen']);
        }
        if (isset($data['mas_comentarios'])) {
            $iniciativa->setMasComentarios($data['mas_comentarios']);
        }
        if (isset($data['redes_sociales'])) {
            $iniciativa->setRedesSociales($data['redes_sociales']);
        }

        
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Iniciativa actualizada correctamente'], Response::HTTP_OK);
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
            'explicacion' => $iniciativa->getExplicacion(),
            'fecha_registro' => $iniciativa->getFechaRegistro()->format('Y-m-d H:i:s'),
            'fecha_inicio' => $iniciativa->getFechaInicio()->format('Y-m-d H:i:s'),
            'fecha_fin' => $iniciativa->getFechaFin()->format('Y-m-d H:i:s'),
            'eliminado' => (bool) $iniciativa->isEliminado(),
            'innovador' => (bool) $iniciativa->isInnovador(),
            'anyo_lectivo' => $iniciativa->getAnyoLectivo(),
            'imagen' => $iniciativa->getImagen(),
            'mas_comentarios' => $iniciativa->getMasComentarios(),
            'redes_sociales' => $iniciativa->getRedesSociales(),
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
                'clase' => [
                    'idClase' => $modulosIniciativas->getModulo()->getClase()->getId(),
                    'nombre' => $modulosIniciativas->getModulo()->getClase()->getNombre(),
                ],
            ], $iniciativa->getModulos()->toArray()),
        ];
    }

}
