<?php

namespace App\Service;

use App\Entity\Clase;
use App\Entity\EntidadExterna;
use App\Entity\EntidadExternaIniciativa;
use App\Entity\Iniciativa;
use App\Entity\IniciativaModulo;
use App\Entity\Meta;
use App\Entity\MetaIniciativa;
use App\Entity\Modulo;
use App\Entity\ODS;
use App\Entity\Profesor;
use App\Entity\ProfesorIniciativa;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class IniciativaService
{

    // Constructor con el manejador de entidades
    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

    }

    // Funcion para obtener todas las iniciativas
    public function getIniciativas(): JsonResponse
    {
        $iniciativas = $this->entityManager->getRepository(Iniciativa::class)->findAll();

        // Si no se encuentra la iniciativa, devuelve mensaje de error
        if (!$iniciativas) {
            return new JsonResponse(['message' => 'No se han encontrado iniciativas'], Response::HTTP_NOT_FOUND);
        }

        $data = array_map(fn($iniciativa) => $this->formatIniciativa($iniciativa), $iniciativas);

        return new JsonResponse($data);
    }

    // Funcion para obtener las iniciativas eliminadas
    public function getIniciativasEliminadas(): JsonResponse
    {
        $iniciativas = $this->entityManager->getRepository(Iniciativa::class)->findByEliminado();
        
        // Si no se encuentra la iniciativa, devuelve mensaje de error
        if (!$iniciativas) {
            return new JsonResponse(['message' => 'No se han encontrado iniciativas'], Response::HTTP_NOT_FOUND);
        }

        $data = array_map(fn($iniciativa) => $this->formatIniciativa($iniciativa), $iniciativas);

        return new JsonResponse($data);
    }

    // Funcion para obtener las iniciativas activas
    public function getIniciativasActivas(): JsonResponse
    {
        $iniciativas = $this->entityManager->getRepository(Iniciativa::class)->findByActivas();
        
        // Si no se encuentra la iniciativa, devuelve mensaje de error
        if (!$iniciativas) {
            return new JsonResponse(['message' => 'No se han encontrado iniciativas'], Response::HTTP_NOT_FOUND);
        }

        $data = array_map(fn($iniciativa) => $this->formatIniciativa($iniciativa), $iniciativas);

        return new JsonResponse($data);
    }

    // Funcion para marcar una iniciativa como eliminada
    public function deleteIniciativa(int $id): JsonResponse
    {
        $iniciativa = $this->entityManager->getRepository(Iniciativa::class)->find($id);
        
        // Si no se encuentra la iniciativa, devuelve mensaje de error
        if (!$iniciativa) {
            return new JsonResponse(['message' => 'La Iniciativa no ha sido encontrada'], Response::HTTP_NOT_FOUND);
        }

        // Si la iniciativa ya estaba eliminada, devuelve mensaje de error
        if ($iniciativa->isEliminado() == true) {
            return new JsonResponse(['message' => 'La Iniciativa ya se encontraba eliminada'], Response::HTTP_BAD_REQUEST);
        }
        
        $iniciativa->setEliminado(true);
        
        $this->entityManager->flush();
        
        return new JsonResponse(['message' => 'La Iniciativa eliminada exitosamente'], Response::HTTP_OK);
    }

    // Funcion para crear una iniciativa
    public function createIniciativa(array $data): JsonResponse
    {
        $iniciativa = new Iniciativa();
        
        $iniciativa->setTipo($data['tipo'] ?? null);
        $iniciativa->setHoras($data['horas'] ?? null);
        $iniciativa->setNombre($data['nombre'] ?? null);
        $iniciativa->setExplicacion($data['explicacion'] ?? null);
        
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
        $iniciativa->setMasComentarios($data['mas_comentarios'] ?? null);
        $iniciativa->setRedesSociales($data['redes_sociales'] ?? null);

        $fechaRegistro = \DateTime::createFromFormat('Y-m-d', (new \DateTime())->format('Y-m-d'));
        $iniciativa->setFechaRegistro($fechaRegistro);

        if (!empty($data['metas']) && is_array($data['metas'])) {
            $metasRepo = $this->entityManager->getRepository(Meta::class);
            foreach ($data['metas'] as $metaId) {
                $meta = $metasRepo->find($metaId);
                if ($meta) {
                    $iniciativaMeta = new MetaIniciativa($iniciativa, $meta);
                    $iniciativa->addMetasIniciativa($iniciativaMeta);
                    $this->entityManager->persist($iniciativaMeta);
                }
            }
        }else {
            return new JsonResponse(['message' => 'Debes de introducir al menos'], Response::HTTP_NOT_FOUND);
        }

        if (!empty($data['profesores']) && is_array($data['profesores'])) {
            $profesorRepo = $this->entityManager->getRepository(Profesor::class);
            foreach ($data['profesores'] as $profesorId) {
                $profesor = $profesorRepo->find($profesorId);
                if ($profesor) {
                    $iniciativaProfesor = new ProfesorIniciativa($iniciativa, $profesor);
                    $iniciativa->addProfesor($iniciativaProfesor);
                    $this->entityManager->persist($iniciativaProfesor);
                }
            }
        }else{
            return new JsonResponse(['message' => 'Debes de introducir al menos un profesor'], Response::HTTP_NOT_FOUND);
        }

        if (!empty($data['entidades_externas']) && is_array($data['entidades_externas'])) {
            $entidadesExternasRepo = $this->entityManager->getRepository(EntidadExterna::class);
            foreach ($data['entidades_externas'] as $entidadExternaId) {
                $entidadExterna = $entidadesExternasRepo->find($entidadExternaId);
                if ($entidadExterna) {
                    $iniciativaEntidadExterna = new EntidadExternaIniciativa($iniciativa, $entidadExterna);
                    $iniciativa->addEntidadesExterna($iniciativaEntidadExterna);
                    $this->entityManager->persist($iniciativaEntidadExterna);
                }
            }
        }else{
            return new JsonResponse(['message' => 'Debes de introducir al menos una entidad externa'], Response::HTTP_NOT_FOUND);
        }

        if (!empty($data['modulos']) && is_array($data['modulos'])) {
            $modulosRepo = $this->entityManager->getRepository(Modulo::class);

            foreach ($data['modulos'] as $moduloId) {
                $modulo = $modulosRepo->find($moduloId);
                if ($entidadExterna) {
                    $iniciativaModulo = new IniciativaModulo($iniciativa, $modulo);
                    $iniciativa->addModulo($iniciativaModulo);
                    $this->entityManager->persist($iniciativaModulo);
                }
            }
        }else{
            return new JsonResponse(['message' => 'Debes de introducir al menos un modulo'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->persist($iniciativa);
        $this->entityManager->flush();

        return new JsonResponse([
            'message' => 'Iniciativa creada correctamente',
        ], Response::HTTP_CREATED);
    }

    // Función para actualizar iniciativa
    public function updateIniciativa(int $id, array $data): JsonResponse
    {
        $iniciativa = $this->entityManager->getRepository(Iniciativa::class)->find($id);
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
        
        $fechaRegistro = \DateTime::createFromFormat('Y-m-d', (new \DateTime())->format('Y-m-d'));
        $iniciativa->setFechaRegistro($fechaRegistro);

        if (isset($data['mas_comentarios'])) {
            $iniciativa->setMasComentarios($data['mas_comentarios']);
        }
        if (isset($data['redes_sociales'])) {
            $iniciativa->setRedesSociales($data['redes_sociales']);
        }

        if (!empty($data['metas']) && is_array($data['metas'])) {
            // Relacionar Metas
            $metasRepo = $this->entityManager->getRepository(Meta::class);

            foreach ($iniciativa->getMetasIniciativas() as $metasIniciativas) {
                $this->entityManager->remove($metasIniciativas);
            }
            $this->entityManager->flush(); 

            foreach ($data['metas'] as $metaId) {
                $meta = $metasRepo->find($metaId);
                if ($meta) {
                    $iniciativaMeta = new MetaIniciativa($iniciativa, $meta);
                    $iniciativa->addMetasIniciativa($iniciativaMeta);
                    $this->entityManager->persist($iniciativaMeta);
                }
            }
        }else{
            return new JsonResponse(['message' => 'Debes de introducir al menos una meta'], Response::HTTP_NOT_FOUND);
        }

        // Relacionar Profesores
        if (!empty($data['profesores']) && is_array($data['profesores'])) {
            $profesorRepo = $this->entityManager->getRepository(Profesor::class);

            foreach ($iniciativa->getProfesores() as $profesores) {
                $this->entityManager->remove($profesores);
            }
            $this->entityManager->flush(); 
    
            foreach ($data['profesores'] as $profesorId) {
                $profesor = $profesorRepo->find($profesorId);
                if ($profesor) {
                    $iniciativaProfesor = new ProfesorIniciativa($iniciativa, $profesor);
                    $iniciativa->addProfesor($iniciativaProfesor);
                    $this->entityManager->persist($iniciativaProfesor);
                }
            }
        }else{
            return new JsonResponse(['message' => 'Debes de introducir al menos un profesor'], Response::HTTP_NOT_FOUND);
        }

        // Relacionar Entidades Externas
        if (!empty($data['entidades_externas']) && is_array($data['entidades_externas'])) {
            $entidadesExternasRepo = $this->entityManager->getRepository(EntidadExterna::class);

            foreach ($iniciativa->getEntidadesExternas() as $entidadesExternas) {
                $this->entityManager->remove($entidadesExternas);
            }
            $this->entityManager->flush(); 
    
            foreach ($data['entidades_externas'] as $entidadExternaId) {
                $entidadExterna = $entidadesExternasRepo->find($entidadExternaId);
                if ($entidadExterna) {
                    $iniciativaEntidadExterna = new EntidadExternaIniciativa($iniciativa, $entidadExterna);
                    $iniciativa->addEntidadesExterna($iniciativaEntidadExterna);
                    $this->entityManager->persist($iniciativaEntidadExterna);
                }
            }
        }else {
            return new JsonResponse(['message' => 'Debes de introducir al menos una entidad externa'], Response::HTTP_NOT_FOUND);
        }

        // Relacionar Módulos
        if (!empty($data['modulos']) && is_array($data['modulos'])) {
            $modulosRepo = $this->entityManager->getRepository(Modulo::class);

            foreach ($iniciativa->getModulos() as $modulos) {
                $this->entityManager->remove($modulos);
            }
            $this->entityManager->flush(); 
    
            foreach ($data['modulos'] as $moduloId) {
                $modulo = $modulosRepo->find($moduloId);
                if ($entidadExterna) {
                    $iniciativaModulo = new IniciativaModulo($iniciativa, $modulo);
                    $iniciativa->addModulo($iniciativaModulo);
                    $this->entityManager->persist($iniciativaModulo);
                }
            }
        }else{
            return new JsonResponse(['message' => 'Debes de introducir al menos un módulo'], Response::HTTP_NOT_FOUND);
        }


        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Iniciativa actualizada correctamente'], Response::HTTP_OK);
    }

    // Funcion para formatear la iniciativa con todos sus campos
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
            'redes_sociales' => $iniciativa->getRedesSociales(),
            'metas' => array_map(fn($metaIniciativa) => [
                'idMeta' => $metaIniciativa->getIdMetas()->getId(),
                'descripcion' => $metaIniciativa->getIdMetas()->getDescripcion(),
                'ods' => [
                    'idOds' => $metaIniciativa->getIdMetas()->getOds()->getId(),
                    'nombre' => $metaIniciativa->getIdMetas()->getOds()->getNombre(),
                    'dimension' => [
                        'idDimension' => $metaIniciativa->getIdMetas()->getOds()->getDimension()->getId(),
                        'nombre' => $metaIniciativa->getIdMetas()->getOds()->getDimension()->getNombre(),
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