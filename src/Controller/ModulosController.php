<?php

namespace App\Controller;

use App\Service\ModulosService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ModulosController extends AbstractController
{
    private ModulosService $modulosService;

    public function __construct(ModulosService $modulosService)
    {
        $this->modulosService = $modulosService;
    }

    #[Route('/modulos', name: 'modulos', methods: ['GET'])]
    public function getCursos(): JsonResponse
    {
        $modulos = $this->modulosService->getAllModulos();
        return $this->json($modulos);
    }
}