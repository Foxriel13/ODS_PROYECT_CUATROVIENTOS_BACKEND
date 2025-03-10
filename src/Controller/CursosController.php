<?php

namespace App\Controller;

use App\Service\ClasesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CursosController extends AbstractController
{
    private ClasesService $clasesService;

    public function __construct(ClasesService $clasesService)
    {
        $this->clasesService = $clasesService;
    }

    #[Route('/cursos', name: 'cursos', methods: ['GET'])]
    public function getCursos(): JsonResponse
    {
        $clases = $this->clasesService->getAllClases();
        return $this->json($clases);
    }
}