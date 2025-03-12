<?php

namespace App\Controller;

use App\Service\ClasesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ClasesController extends AbstractController
{
    private ClasesService $clasesService;

    public function __construct(ClasesService $clasesService)
    {
        $this->clasesService = $clasesService;
    }

    #[Route('/clases', name: 'clases', methods: ['GET'])]
    public function getClases(): JsonResponse
    {
        $clases = $this->clasesService->getAllClases();
        return $this->json($clases);
    }
}