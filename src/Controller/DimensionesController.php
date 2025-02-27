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
    private DimensionesService $dimensionesService;

    public function __construct(DimensionesService $dimensionesService)
    {
        $this->dimensionesService = $dimensionesService;
    }

    #[Route('/dimension', name: 'dimension', methods: ['GET'])]
    public function getDimensiones(): JsonResponse
    {
        $dimensiones = $this->dimensionesService->getAllDimensiones();
        return $this->json(
            $dimensiones,
            200,
            [],
            ['enable_max_depth' => true]
        );
    }

    #[Route('/dimension', name: 'create_dimension', methods: ['POST'])]
    public function createDimension(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['nombre'])) {
            return new JsonResponse(['error' => 'El campo "nombre" es obligatorio.'], Response::HTTP_BAD_REQUEST);
        }

        $dimension = $this->dimensionesService->createDimension($data['nombre']);

        return new JsonResponse([
            'id' => $dimension->getId(),
            'nombre' => $dimension->getNombre(),
        ], Response::HTTP_CREATED);
    }
}