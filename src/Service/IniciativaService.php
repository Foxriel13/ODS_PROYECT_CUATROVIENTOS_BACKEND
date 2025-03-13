<?php

namespace App\Service;

use App\Entity\EntidadExterna;
use App\Entity\EntidadExternaIniciativa;
use App\Entity\Iniciativa;
use App\Entity\IniciativaModulo;
use App\Entity\Meta;
use App\Entity\MetaIniciativa;
use App\Entity\Modulo;
use App\Entity\Profesor;
use App\Entity\ProfesorIniciativa;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class IniciativaService
{

    // Constructor con el manejador de entidades y el serializador
    public function __construct(private EntityManagerInterface $entityManager, private SerializerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    // Funcion para obtener todas las iniciativas
    public function getIniciativas(): JsonResponse
    {
        $iniciativas = $this->entityManager->getRepository(Iniciativa::class)->findAll();

        // Si no se encuentra la iniciativa, devuelve mensaje de error
        if (!$iniciativas) {
            return new JsonResponse(['message' => 'No se han encontrado iniciativas'], Response::HTTP_NOT_FOUND);
        }

        $json = $this->serializer->serialize($iniciativas, 'json');
        return new JsonResponse($json, JsonResponse::HTTP_OK, [], true);
    }

    // Funcion para obtener las iniciativas eliminadas
    public function getIniciativasEliminadas(): JsonResponse
    {
        $iniciativas = $this->entityManager->getRepository(Iniciativa::class)->findByEliminado();

        // Si no se encuentra la iniciativa, devuelve mensaje de error
        if (!$iniciativas) {
            return new JsonResponse(['message' => 'No se han encontrado iniciativas'], Response::HTTP_NOT_FOUND);
        }

        $json = $this->serializer->serialize($iniciativas, 'json');
        return new JsonResponse($json, JsonResponse::HTTP_OK, [], true);
    }

    // Funcion para obtener las iniciativas activas
    public function getIniciativasActivas(): JsonResponse
    {
        $iniciativas = $this->entityManager->getRepository(Iniciativa::class)->findByActivas();

        // Si no se encuentra la iniciativa, devuelve mensaje de error
        if (!$iniciativas) {
            return new JsonResponse(['message' => 'No se han encontrado iniciativas'], Response::HTTP_NOT_FOUND);
        }

        $json = $this->serializer->serialize($iniciativas, 'json');
        return new JsonResponse($json, JsonResponse::HTTP_OK, [], true);
    }

    // Funcion para marcar una iniciativa como eliminada
    public function deleteIniciativa(int $id): JsonResponse
    {
        $iniciativa = $this->entityManager->getRepository(Iniciativa::class)->find($id);

        // Si no se encuentra la iniciativa, devuelve mensaje de error
        if (!$iniciativa) {
            return new JsonResponse(['message' => 'La Iniciativa no encontrada'], Response::HTTP_NOT_FOUND);
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

        $this->entityManager->persist($iniciativa);

        $iniciativa->setTipo($data['tipo'] ?? null);
        $iniciativa->setHoras($data['horas'] ?? null);
        $iniciativa->setNombre($data['nombre'] ?? null);
        $iniciativa->setExplicacion($data['explicacion'] ?? null);
        $iniciativa->setFechaInicio(new \DateTime($data['fecha_inicio'] ?? 'now'));
        $iniciativa->setFechaFin(new \DateTime($data['fecha_fin'] ?? 'now'));
        $iniciativa->setEliminado(false);
        $iniciativa->setInnovador($data['innovador'] ?? false);
        $iniciativa->setAnyoLectivo($data['anyo_lectivo'] ?? null);
        $iniciativa->setImagen($data['imagen'] ?? null);
        $iniciativa->setMasComentarios($data['mas_comentarios'] ?? null);
        $iniciativa->setRedesSociales($data['redes_sociales'] ?? null);

        $fechaRegistro = \DateTime::createFromFormat('Y-m-d', (new \DateTime())->format('Y-m-d'));
        $iniciativa->setFechaRegistro($fechaRegistro);

        $this->anyadirRelacion($iniciativa, $data['metas'] ?? [], MetaIniciativa::class, Meta::class);
        $this->anyadirRelacion($iniciativa, $data['profesores'] ?? [], ProfesorIniciativa::class, Profesor::class);
        $this->anyadirRelacion($iniciativa, $data['entidades_externas'] ?? [], EntidadExternaIniciativa::class, EntidadExterna::class);
        $this->anyadirRelacion($iniciativa, $data['modulos'] ?? [], IniciativaModulo::class, Modulo::class);

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

        $this->entityManager->beginTransaction();

        try {
            $iniciativa->setTipo($data['tipo'] ?? $iniciativa->getTipo());
            $iniciativa->setHoras($data['horas'] ?? $iniciativa->getHoras());
            $iniciativa->setNombre($data['nombre'] ?? $iniciativa->getNombre());
            $iniciativa->setProductoFinal($data['producto_final'] ?? $iniciativa->getProductoFinal());
            $iniciativa->setFechaInicio($data['fecha_inicio'] ? new \DateTime($data['fecha_inicio']) : $iniciativa->getFechaInicio());
            $iniciativa->setFechaFin($data['fecha_fin'] ? new \DateTime($data['fecha_fin']) : $iniciativa->getFechaFin());
            $iniciativa->setEliminado($data['eliminado'] ?? $iniciativa->isEliminado());
            $iniciativa->setInnovador($data['innovador'] ?? $iniciativa->isInnovador());
            $iniciativa->setAnyoLectivo($data['anyo_lectivo'] ?? $iniciativa->getAnyoLectivo());
            $iniciativa->setImagen($data['imagen'] ?? $iniciativa->getImagen());
            $iniciativa->setMasComentarios($data['mas_comentarios'] ?? $iniciativa->getMasComentarios());
            $iniciativa->setRedesSociales($data['redes_sociales'] ?? $iniciativa->getRedesSociales());

            $this->anyadirRelacion($iniciativa, $data['metas'] ?? [], MetaIniciativa::class, Meta::class);
            $this->anyadirRelacion($iniciativa, $data['profesores'] ?? [], ProfesorIniciativa::class, Profesor::class);
            $this->anyadirRelacion($iniciativa, $data['entidades_externas'] ?? [], EntidadExternaIniciativa::class, EntidadExterna::class);
            $this->anyadirRelacion($iniciativa, $data['modulos'] ?? [], IniciativaModulo::class, Modulo::class);

            $this->entityManager->flush();
            $this->entityManager->commit();

            return new JsonResponse(['message' => 'Iniciativa actualizada correctamente'], Response::HTTP_OK);
        } catch (\Exception $e) {
            $this->entityManager->rollback();
            return new JsonResponse(['message' => 'Error al actualizar la iniciativa'], Response::HTTP_BAD_REQUEST);
        }
    }

    // Funcion para anyadir relaciones a la iniciativa
    private function anyadirRelacion(Iniciativa $iniciativa, array $ids, string $claseRelacion, string $claseEntidad): void
    {
        $repo = $this->entityManager->getRepository($claseEntidad);
        foreach ($ids as $id) {
            $target = $repo->find($id);
            if ($target) {
                $relation = new $claseRelacion($iniciativa, $target);
                $iniciativa->{'add' . $claseRelacion}($relation);
                $this->entityManager->persist($relation);
            }
        }
    }
}