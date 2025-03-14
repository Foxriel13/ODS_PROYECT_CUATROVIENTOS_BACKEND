<?php

namespace App\Controller;

use App\Service\ModulosService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ModulosController extends AbstractController
{

    // Constructor con el servicio de la entidad Meta
    public function __construct(private ModulosService $modulosService)
    {
        $this->modulosService = $modulosService;
    }

    // Get de las Modulos
    #[Route('/modulos', name: 'modulos', methods: ['GET'])]
    public function getModulos(): JsonResponse
    {
        return $this->modulosService->getAllModulos();
    }
    
}