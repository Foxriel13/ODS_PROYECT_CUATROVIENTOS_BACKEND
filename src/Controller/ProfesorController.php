<?php

namespace App\Controller;

use App\Service\ProfesorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfesorController extends AbstractController
{

    // Constructor con el servicio de la entidad Profesor
    public function __construct(private ProfesorService $profesorService)
    {
        $this->profesorService = $profesorService;
    }

    // Get de las Profesores
    #[Route('/profesores', name: 'get_profesores', methods: ['GET'])]
    public function getProfesores(): JsonResponse
    {
        return $this->profesorService->getAllProfesores();
    }
    
    // Crear Profesor
    #[Route('/profesores', name: 'create_profesor', methods: ['POST'])]
    public function createProfesor(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        if (!is_array($data)) {
            return new JsonResponse(
                ['message' => 'Datos inválidos o formato incorrecto'],
                Response::HTTP_BAD_REQUEST
            );
        }
    
        return $this->profesorService->createProfesor($data);
    }

    // Actualizar Profesor
    #[Route('/profesores/{idProfesor}', name: 'update_profesor', methods: ['PUT'])]
    public function updateProfesor(Request $request, int $idProfesor): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        if (!$data) {
            return new JsonResponse(['message' => 'Datos inválidos'], Response::HTTP_BAD_REQUEST);
        }
    
        return $this->profesorService->updateProfesor($idProfesor, $data);
    }

    // Eliminar Profesor
    #[Route('/profesores/{idProfesor}', name: 'delete_profesor', methods: ['DELETE'])]
    public function deleteProfesor(int $idProfesor): JsonResponse
    {
        return $this->profesorService->deleteProfesor($idProfesor);
    }

}