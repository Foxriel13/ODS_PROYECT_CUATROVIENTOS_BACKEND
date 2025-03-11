<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Service\IniciativaService;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Intl\Data\Bundle\Writer\JsonBundleWriter;
use Symfony\Component\Routing\Attribute\Route;

final class IniciativaController extends AbstractController
{
    private IniciativaService $iniciativaService;

    public function __construct(IniciativaService $iniciativaService)
    {
        $this->iniciativaService = $iniciativaService;
    }

    // Get de las iniciativas
    #[Route('/iniciativas', methods: ['GET'])]
    public function searchIniciativas(Request $request): JsonResponse
    {
        $eliminado = $request->query->get('eliminado');

        if ($eliminado == 'true') {
            return $this->iniciativaService->getIniciativasEliminadas();
        }elseif ($eliminado == 'false') {
            return $this->iniciativaService->getIniciativasActivas();
        }else{
            return $this->iniciativaService->getIniciativas();    
        }

    } 

    // Marcar como eliminado
    #[Route('/deleteIniciativas/{idIniciativa}', methods: ['PUT'])]
    public function deleteIniciativa( int $idIniciativa): JsonResponse
    {
        return $this->iniciativaService->deleteIniciativa($idIniciativa);
    }
    
    // Crear iniciativa
    #[Route('/iniciativas', methods: ['POST'])]
    public function createIniciativa(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

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