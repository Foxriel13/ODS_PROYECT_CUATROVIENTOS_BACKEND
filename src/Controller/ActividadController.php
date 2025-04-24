<?php

namespace App\Controller;

use App\Service\ActividadService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ActividadController extends AbstractController
{

    // Constructor con el servicio de la entidad Actividad
    public function __construct(private ActividadService $actividadService)
    {
        $this->actividadService = $actividadService;
    }

    // Obtener todas las actividades
    #[Route('/actividades', name: 'get_actividades', methods: ['GET'])]
    public function getActividades(): JsonResponse
    {
        $actividades = $this->actividadService->getAllActividades();

        if (empty($actividades)) {
            return new JsonResponse(
                ['message' => 'No se han encontrado actividades'],
                Response::HTTP_BAD_REQUEST
            );
        }

        return $actividades;
    }

    // Crear actividades
    #[Route('/actividades', name: 'create_actividad', methods: ['POST'])]
    public function createActividad(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
 
        if (!is_array($data)) {
            return new JsonResponse(
                ['message' => 'Datos inválidos o formato incorrecto'],
                Response::HTTP_BAD_REQUEST
            );
        }
 
        return $this->actividadService->createActividad($data);
    }

    // Actualizar actividades
    #[Route('/actividades/{idActividad}', name: 'update_actividad', methods: ['PUT'])]
    public function updateActividad(Request $request, int $idActividad): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        if (!$data) {
            return new JsonResponse(['message' => 'Datos inválidos'], Response::HTTP_BAD_REQUEST);
        }
    
        return $this->actividadService->updateActividad($idActividad, $data);
    }

    // Eliminar actividades
    #[Route('/actividades/{idActividad}', name: 'delete_actividad', methods: ['DELETE'])]
    public function deleteActividad(int $idActividad): JsonResponse
    {
        return $this->actividadService->deleteActividad($idActividad);
    }

}