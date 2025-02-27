<?php

namespace App\Controller;

use App\Service\CursosService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CursosController extends AbstractController
{
    private CursosService $cursosService;

    public function __construct(CursosService $cursosService)
    {
        $this->cursosService = $cursosService;
    }

    #[Route('/cursos', name: 'cursos', methods: ['GET'])]
    public function getCursos(): JsonResponse
    {
        $cursos = $this->cursosService->getAllCursos();
        return $this->json($cursos);
    }
}