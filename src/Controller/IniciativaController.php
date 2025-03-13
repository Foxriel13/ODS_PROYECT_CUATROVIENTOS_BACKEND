<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Service\IniciativaService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class IniciativaController extends AbstractController
{

    // Constructor con el servicio de la entidad Iniciativa
    public function __construct(private IniciativaService $iniciativaService)
    {
        $this->iniciativaService = $iniciativaService;
    }

    // Get de las iniciativas
    #[Route('/iniciativas', methods: ['GET'])]
    public function getIniciativas(Request $request): JsonResponse
    {
        $eliminado = $request->query->get('eliminado');

        // Si el campo eliminado es true, sacamos las iniciativas eliminadas, si es false las activas y si no las todas
        if ($eliminado == 'true') {
            return $this->iniciativaService->getIniciativasEliminadas();
        }elseif ($eliminado == 'false') {
            return $this->iniciativaService->getIniciativasActivas();
        }else{
            return $this->iniciativaService->getIniciativas();    
        }
        
    } 

    // Marcar como eliminado una inicitativa
    #[Route('/iniciativas/{idIniciativa}', methods: ['DELETE'])]
    public function deleteIniciativa( int $idIniciativa): JsonResponse
    {
        return $this->iniciativaService->deleteIniciativa($idIniciativa);
    }
    
    // Crear iniciativa
    #[Route('/iniciativas', methods: ['POST'])]
    public function createIniciativa(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Comprobamos que los datos sean correctos
        if (!is_array($data)) {
            return new JsonResponse(
                ['message' => 'Datos inválidos o formato incorrecto'],
                Response::HTTP_BAD_REQUEST
            );
        }

        return $this->iniciativaService->createIniciativa($data);
    }

    // Actualizar iniciativa
    #[Route('/iniciativas/{idIniciativa}', methods: ['PUT'])]
    public function updateIniciativa(Request $request, int $idIniciativa): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        if (!$data) {
            return new JsonResponse(['message' => 'Datos inválidos'], Response::HTTP_BAD_REQUEST);
        }
    
        return $this->iniciativaService->updateIniciativa($idIniciativa, $data);
    }
    
}