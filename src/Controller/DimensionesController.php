<?php

namespace App\Controller;

use App\Service\DimensionesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

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
        return $this->json($dimensiones);
    }

}