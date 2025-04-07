<?php

namespace App\Controller;

use App\Service\ODSService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ODSController extends AbstractController
{

    // Constructor con el servicio de la entidad ODS
    public function __construct(private ODSService $odsService)
    {
        $this->odsService = $odsService;
    }

    // Get de las ODS
    #[Route('/ods', name: 'ods', methods: ['GET'])]
    public function getOds(): JsonResponse
    {
        return $this->odsService->getAllOds();
    }

    // Crear Ods
    #[Route('/ods', methods: ['POST'])]
    public function createOds(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        if (!is_array($data)) {
            return new JsonResponse(
                ['message' => 'Datos inválidos o formato incorrecto'],
                Response::HTTP_BAD_REQUEST
            );
        }
    
        return $this->odsService->createOds($data);
    }

    // Actualizar Ods
    #[Route('/ods/{idOds}', methods: ['PUT'])]
    public function updateOds(Request $request, int $idOds): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        if (!$data) {
            return new JsonResponse(['message' => 'Datos inválidos'], Response::HTTP_BAD_REQUEST);
        }

        return $this->odsService->updateOds($idOds, $data);
    }

    // Eliminar Ods
    #[Route('/ods/{idOds}', name: 'delete_ods', methods: ['DELETE'])]
    public function deleteOds(int $idOds): JsonResponse
    {
        return $this->odsService->deleteOds($idOds);
    }

}