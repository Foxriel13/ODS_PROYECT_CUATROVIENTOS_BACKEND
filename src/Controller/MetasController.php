<?php

namespace App\Controller;

use App\Service\MetasService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MetasController extends AbstractController
{

    // Constructor con el servicio de la entidad Meta
    public function __construct(private MetasService $metasService)
    {
        $this->metasService = $metasService;
    }

    // Get de las Metas
    #[Route('/metas', name: 'get_metas', methods: ['GET'])]
    public function getMetas(): JsonResponse
    {
        return $this->metasService->getAllMetas();
    }
    
    // Crear Meta
    #[Route('/metas', name: 'create_meta', methods: ['POST'])]
    public function createMeta(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        if (!is_array($data)) {
            return new JsonResponse(
                ['message' => 'Datos inválidos o formato incorrecto'],
                Response::HTTP_BAD_REQUEST
            );
        }
    
        return $this->metasService->createMeta($data);
    }
    
    // Actualizar Meta
    #[Route('/metas/{idMeta}', name: 'update_meta', methods: ['PUT'])]
    public function updateMeta(Request $request, int $idMeta): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        if (!$data) {
            return new JsonResponse(['message' => 'Datos inválidos'], Response::HTTP_BAD_REQUEST);
        }
    
        return $this->metasService->updateMeta($idMeta, $data);
    }
    
    #[Route('/metas/{idMeta}', name: 'delete_meta', methods: ['DELETE'])]
    public function deleteMeta(int $idMeta): JsonResponse
    {
        return $this->metasService->deleteMeta($idMeta);
    }
    
}