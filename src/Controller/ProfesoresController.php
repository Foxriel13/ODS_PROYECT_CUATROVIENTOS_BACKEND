<?php

namespace App\Controller;

use App\Service\ProfesoresService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ProfesoresController extends AbstractController
{
    private ProfesoresService $profesoresService;

    public function __construct(ProfesoresService $profesoresService)
    {
        $this->profesoresService = $profesoresService;
    }

    #[Route('/profesores', name: 'profesores', methods: ['GET'])]
    public function getCursos(): JsonResponse
    {
        $profesores = $this->profesoresService->getAllProfesores();
        return $this->json($profesores);
    }
}