<?php

namespace App\Controller;

use App\Service\ClaseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ClaseController extends AbstractController
{

    // Constructor con el servicio de la entidad Clase
    public function __construct(private ClaseService $claseService)
    {
        $this->claseService = $claseService;
    }

    // Obtener todas las clases
    #[Route('/clases', name: 'get_clases', methods: ['GET'])]
    public function getClases(): JsonResponse
    {
        $clases = $this->claseService->getAllClases();

        if (empty($clases)) {
            return new JsonResponse(
                ['message' => 'No se han encontrado clases'],
                Response::HTTP_BAD_REQUEST
            );
        }

        return $clases;
    }

    // Crear Clase
    #[Route('/clases', name: 'create_clase', methods: ['POST'])]
    public function createClase(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
 
        if (!is_array($data)) {
            return new JsonResponse(
                ['message' => 'Datos inválidos o formato incorrecto'],
                Response::HTTP_BAD_REQUEST
            );
        }
 
        return $this->claseService->createClase($data);
    }

    // Actualizar Clase
    #[Route('/clases/{idClase}', name : 'update_clase', methods: ['PUT'])]
    public function updateClase(Request $request, int $idClase): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        if (!$data) {
            return new JsonResponse(['message' => 'Datos inválidos'], Response::HTTP_BAD_REQUEST);
        }
    
        return $this->claseService->updateClase($idClase, $data);
    }

    // Eliminar Clase
    #[Route('/clases/{idClase}', name: 'delete_clase', methods: ['DELETE'])]
    public function deleteClase(int $idClase): JsonResponse
    {
        return $this->claseService->deleteClase($idClase);
    }

}