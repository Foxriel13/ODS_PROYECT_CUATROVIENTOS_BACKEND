<?php

namespace App\Controller;

use App\Service\ActividadesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ActividadesController extends AbstractController
{

    // Constructor con el servicio de la entidad Actividad
    public function __construct(private ActividadesService $actividadesService)
    {
        $this->actividadesService = $actividadesService;
    }

    // Obtener todas las actividades
    #[Route('/actividades', name: 'get_actividades', methods: ['GET'])]
    public function getActividades(): JsonResponse
    {
        $actividades = $this->actividadesService->getAllActividades();

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
 
        return $this->actividadesService->createActividad($data);
    }

    // Actualizar actividades
    #[Route('/actividades/{idActividad}', name: 'update_actividad', methods: ['PUT'])]
    public function updateActividad(Request $request, int $idActividad): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        if (!$data) {
            return new JsonResponse(['message' => 'Datos inválidos'], Response::HTTP_BAD_REQUEST);
        }
    
        return $this->actividadesService->updateActividad($idActividad, $data);
    }

    // Eliminar actividades
    #[Route('/actividades/{idActividad}', name: 'delete_actividad', methods: ['DELETE'])]
    public function deleteActividad(int $idActividad): JsonResponse
    {
        return $this->actividadesService->deleteActividad($idActividad);
    }

}