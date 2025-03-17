<?php

namespace App\Controller;

use App\Service\ClasesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ClasesController extends AbstractController
{

    // Constructor con el servicio de la entidad Clase
    public function __construct(private ClasesService $clasesService)
    {
        $this->clasesService = $clasesService;
    }

    // Obtener todas las clases
    #[Route('/clases', name: 'clases', methods: ['GET'])]
    public function getClases(): JsonResponse
    {
        $clases = $this->clasesService->getAllClases();

        if (empty($clases)) {
            return new JsonResponse(
                ['message' => 'No se han encontrado clases'],
                Response::HTTP_BAD_REQUEST
            );
        }

        return $clases;
    }

    // Crear Clase
    #[Route('/clases', methods: ['POST'])]
    public function createClase(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
 
 
        if (!is_array($data)) {
            return new JsonResponse(
                ['message' => 'Datos inválidos o formato incorrecto'],
                Response::HTTP_BAD_REQUEST
            );
        }
 
        return $this->clasesService->createClase($data);
    }

    // Actualizar Clase
    #[Route('/clases/{idClase}', methods: ['PUT'])]
    public function updateClase(Request $request, int $idClase): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        if (!$data) {
            return new JsonResponse(['message' => 'Datos inválidos'], Response::HTTP_BAD_REQUEST);
        }
    
        return $this->clasesService->updateClase($idClase, $data);
    }

    // Eliminar Clase
    #[Route('/clases/{id}', name: 'delete_clase', methods: ['DELETE'])]
    public function deleteClase(int $id): JsonResponse
    {
        return $this->clasesService->deleteClase($id);
    }

}