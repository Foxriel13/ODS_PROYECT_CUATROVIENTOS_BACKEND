<?php

namespace App\Service;

use App\Entity\Clase;
use App\Entity\EntidadExterna;
use App\Entity\EntidadExternaIniciativa;
use App\Entity\Iniciativa;
use App\Entity\IniciativaModulo;
use App\Entity\IniciativaRedesSociales;
use App\Entity\Meta;
use App\Entity\MetaIniciativa;
use App\Entity\Modulo;
use App\Entity\ModuloClase;
use App\Entity\Profesor;
use App\Entity\ProfesorIniciativa;
use App\Entity\RedesSociales;
use App\Entity\Actividad;
use App\Entity\IniciativaActividad;
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
        } else {
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
        } else {
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
        } else {
            return new JsonResponse(['message' => 'Debes de introducir al menos una entidad externa'], Response::HTTP_NOT_FOUND);
        }

        if (!empty($data['modulos']) && is_array($data['modulos'])) {
            $modulosRepo = $this->entityManager->getRepository(Modulo::class);
            $clasesRepo = $this->entityManager->getRepository(Clase::class);
        
            foreach ($data['modulos'] as $moduloData) {
                // Esperamos que cada item sea un array con 'id' y 'clases'
                $moduloId = $moduloData['id'] ?? null;
                $claseIds = $moduloData['clases'] ?? [];
        
                if (!$moduloId || empty($claseIds)) {
                    continue;
                }
        
                $modulo = $modulosRepo->find($moduloId);
        
                if ($modulo) {
                    // Asociar el módulo a la iniciativa
                    $iniciativaModulo = new IniciativaModulo($iniciativa, $modulo);
                    $iniciativa->addModulo($iniciativaModulo);
                    $this->entityManager->persist($iniciativaModulo);
        
                    // Asociar clases al módulo
                    foreach ($claseIds as $claseId) {
                        $clase = $clasesRepo->find($claseId);
                        if ($clase) {
                            $moduloClase = new ModuloClase($modulo, $clase);
                            $modulo->addModuloClase($moduloClase);
                            $this->entityManager->persist($moduloClase);
                        }
                    }
                }
            }
        } else {
            return new JsonResponse(['message' => 'Debes de introducir al menos un módulo con clases'], Response::HTTP_NOT_FOUND);
        }
        
        

        // Procesamos redes sociales
        if (!empty($data['redes_sociales']) && is_array($data['redes_sociales'])) {
            $redesSocialesRepo = $this->entityManager->getRepository(RedesSociales::class);
            foreach ($data['redes_sociales'] as $redesSocialesId) {
                $redSocial = $redesSocialesRepo->find($redesSocialesId);
                if ($redSocial) {
                    $iniciativaRedSocial = new IniciativaRedesSociales($iniciativa, $redSocial);
                    $iniciativa->addIniciativaRedesSociale($iniciativaRedSocial);
                    $this->entityManager->persist($iniciativaRedSocial);
                }
            }
        } else {
            return new JsonResponse(['message' => 'Debes de introducir al menos una red social'], Response::HTTP_NOT_FOUND);
        }

        // Procesamos actividades
        if (!empty($data['actividades']) && is_array($data['actividades'])) {
            $actividadesRepo = $this->entityManager->getRepository(Actividad::class);
            foreach ($data['actividades'] as $actividadId) {
                $actividad = $actividadesRepo->find($actividadId);
                if ($actividad) {
                    $iniciativaActividad = new IniciativaActividad($iniciativa, $actividad);
                    $iniciativa->addIniciativaActividad($iniciativaActividad);
                    $this->entityManager->persist($iniciativaRedSocial);
                }
            }
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

        // Relacionar Metas
        if (!empty($data['metas']) && is_array($data['metas'])) {
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
        } else {
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
        } else {
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
        } else {
            return new JsonResponse(['message' => 'Debes de introducir al menos una entidad externa'], Response::HTTP_NOT_FOUND);
        }

        if (!empty($data['modulos']) && is_array($data['modulos'])) {
            $modulosRepo = $this->entityManager->getRepository(Modulo::class);
            $clasesRepo = $this->entityManager->getRepository(Clase::class);
        
            // Eliminar relaciones antiguas de módulos y sus clases
            foreach ($iniciativa->getModulos() as $iniciativaModulo) {
                $modulo = $iniciativaModulo->getModulo();
                foreach ($modulo->getModuloClases() as $moduloClase) {
                    $this->entityManager->remove($moduloClase);
                }
                $this->entityManager->remove($iniciativaModulo);
            }
            $this->entityManager->flush();
        
            foreach ($data['modulos'] as $moduloData) {
                $moduloId = $moduloData['id'] ?? null;
                $claseIds = $moduloData['clases'] ?? [];
        
                if (!$moduloId || empty($claseIds)) {
                    continue;
                }
        
                $modulo = $modulosRepo->find($moduloId);
                if ($modulo) {
                    // Relacionar módulo con iniciativa
                    $iniciativaModulo = new IniciativaModulo($iniciativa, $modulo);
                    $iniciativa->addModulo($iniciativaModulo);
                    $this->entityManager->persist($iniciativaModulo);
        
                    // Relacionar clases al módulo
                    foreach ($claseIds as $claseId) {
                        $clase = $clasesRepo->find($claseId);
                        if ($clase) {
                            $moduloClase = new ModuloClase($modulo, $clase);
                            $modulo->addModuloClase($moduloClase);
                            $this->entityManager->persist($moduloClase);
                        }
                    }
                }
            }
        } else {
            return new JsonResponse(['message' => 'Debes de introducir al menos un módulo con clases'], Response::HTTP_NOT_FOUND);
        }

        // Relacionar Redes Sociales
        if (!empty($data['redes_sociales']) && is_array($data['redes_sociales'])) {
            $redesSocialesRepo = $this->entityManager->getRepository(RedesSociales::class);
            
            foreach ($iniciativa->getIniciativaRedesSociales() as $redSocial) {
                $this->entityManager->remove($redSocial);
            }
            $this->entityManager->flush();

            foreach ($data['redes_sociales'] as $redSocialId) {
                $redSocial = $redesSocialesRepo->find($redSocialId);
                if ($redSocial) {
                    $redSocialIniciativa = new IniciativaRedesSociales($iniciativa, $redSocial);
                    $iniciativa->addIniciativaRedesSociale($redSocialIniciativa);
                    $this->entityManager->persist($redSocialIniciativa);
                }
            }
            
        } else {
            return new JsonResponse(['message' => 'Debes de introducir al menos una red social'], Response::HTTP_NOT_FOUND);
        }

        // Relacionar Actividades
        if (!empty($data['actividades']) && is_array($data['actividades'])) {
            $actividadesesRepo = $this->entityManager->getRepository(Actividad::class);
            
            foreach ($iniciativa->getIniciativaActividad() as $actividad) {
                $this->entityManager->remove($actividad);
            }
            $this->entityManager->flush();

            foreach ($data['actividades'] as $actividadId) {
                $actividad = $actividadesesRepo->find($actividadId);
                if ($actividad) {
                    $iniciativaActividad = new IniciativaActividad($iniciativa, $actividad);
                    $iniciativa->addIniciativaActividad($iniciativaActividad);
                    $this->entityManager->persist($iniciativaActividad);
                }
            }
            
        } else {
            return new JsonResponse(['message' => 'Debes de introducir al menos una actividad'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Iniciativa actualizada correctamente'], Response::HTTP_OK);
    }

    // Funcion para formatear la iniciativa con todos sus campos
    private function formatIniciativa($iniciativa): array
    {
        return [
            'id' => $iniciativa->getId(),
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
            'modulos' => array_map(fn($iniciativaModulo) => [
                'idModulo' => $iniciativaModulo->getModulo()->getId(),
                'nombre' => $iniciativaModulo->getModulo()->getNombre(),
                'clases' => array_map(fn($modulosClase) => [
                    'idClase' => $modulosClase->getClase()->getId(),
                    'nombre' => $modulosClase->getClase()->getNombre(),
                ], $iniciativaModulo->getModulo()->getModuloClases()->toArray()),
            ], $iniciativa->getModulos()->toArray()),
            'redes_sociales' => array_map(fn($iniciativaRedSocial) => [
                'idRedSocial' => $iniciativaRedSocial->getRedesSociales()->getId(),
                'nombre' => $iniciativaRedSocial->getRedesSociales()->getNombre(),
                'enlace' => $iniciativaRedSocial->getRedesSociales()->getEnlace(),
            ], $iniciativa->getIniciativaRedesSociales()->toArray()),
            'actividades' => array_map(fn($iniciativaActividad) => [
                'idActividad' => $iniciativaActividad->getActividad()->getId(),
                'nombre' => $iniciativaActividad->getActividad()->getNombre(),
            ], $iniciativa->getIniciativaActividades()->toArray()),
        ];
    }
}
