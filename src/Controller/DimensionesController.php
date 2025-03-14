<?php

namespace App\Controller;

use App\Service\DimensionesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DimensionesController extends AbstractController
{

    // Constructor con el servicio de la entidad Dimension
    public function __construct(private DimensionesService $dimensionesService)
    {
        $this->dimensionesService = $dimensionesService;
    }

    // Get de las dimensiones
    #[Route('/dimensiones', name: 'dimensiones', methods: ['GET'])]
    public function getDimensiones(): JsonResponse
    {
        return $this->dimensionesService->getAllDimensiones();
    }

    // Crear Dimensión
    #[Route('/dimensiones', methods: ['POST'])]
    public function createDimension(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!is_array($data)) {
            return new JsonResponse(
                ['message' => 'Datos inválidos o formato incorrecto'],
                Response::HTTP_BAD_REQUEST
            );
        }

        return $this->dimensionesService->createDimension($data);
    }


    // Actualizar Dimensión
    #[Route('/dimensiones/{idDimension}', methods: ['PUT'])]
    public function updateClase(Request $request, int $idDimension): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
   
        if (!$data) {
            return new JsonResponse(['message' => 'Datos inválidos'], Response::HTTP_BAD_REQUEST);
        }
   
        return $this->dimensionesService->updateDimension($idDimension, $data);
    }

    // Eliminar Dimensión
    #[Route('/dimensiones/{id}', name: 'delete_dimension', methods: ['DELETE'])]
    public function deleteDimension(int $id): JsonResponse
    {
        return $this->dimensionesService->deleteDimension($id);
    }


}