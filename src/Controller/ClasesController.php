<?php

namespace App\Controller;

use App\Service\ClasesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ClasesController extends AbstractController
{

    // Constructor con el servicio de la entidad Clase
    public function __construct(private ClasesService $clasesService)
    {
        $this->clasesService = $clasesService;
    }

    // Get de las clases
    #[Route('/clases', name: 'clases', methods: ['GET'])]
    public function getClases(): JsonResponse
    {
        return $this->clasesService->getAllClases();
    }

}