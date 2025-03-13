<?php

namespace App\Controller;

use App\Service\ProfesoresService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ProfesoresController extends AbstractController
{

    // Constructor con el servicio de la entidad Profesor
    public function __construct(private ProfesoresService $profesoresService)
    {
        $this->profesoresService = $profesoresService;
    }

    // Get de las Profesores
    #[Route('/profesores', name: 'profesores', methods: ['GET'])]
    public function getProfesores(): JsonResponse
    {
        return $this->profesoresService->getAllProfesores();
    }
    
}