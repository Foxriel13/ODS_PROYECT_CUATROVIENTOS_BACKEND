<?php

namespace App\Controller;

use App\Service\DimensionesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

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
        $dimensiones = $this->dimensionesService->getAllDimensiones();
        return $this->json($dimensiones);
    }

}