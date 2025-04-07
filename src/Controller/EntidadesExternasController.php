<?php

namespace App\Controller;

use App\Service\EntidadesExternasService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EntidadesExternasController extends AbstractController
{

    // Constructor con el servicio de la entidad EntidadExterna
    public function __construct(private EntidadesExternasService $entidadesExternasService)
    {
        $this->entidadesExternasService = $entidadesExternasService;
    }

    // Get de las Entidades Externas
    #[Route('/entidadesexternas', name: 'entidadesExternas', methods: ['GET'])]
    public function getEntidadesExternas(): JsonResponse
    {
        return $this->entidadesExternasService->getAllEntidadesExternas();
    }

    // Crear Entidad Externa
    #[Route('/entidadesexternas', methods: ['POST'])]
    public function createEntidadExterna(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        if (!is_array($data)) {
            return new JsonResponse(
                ['message' => 'Datos inválidos o formato incorrecto'],
                Response::HTTP_BAD_REQUEST
            );
        }
    
        return $this->entidadesExternasService->createEntidadExterna($data);
    }

    // Actualizar Entidad Externa
    #[Route('/entidadesexternas/{idEntidadExterna}', methods: ['PUT'])]
    public function updateEntidadExterna(Request $request, int $idEntidadExterna): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        if (!$data) {
            return new JsonResponse(['message' => 'Datos inválidos'], Response::HTTP_BAD_REQUEST);
        }
    
        return $this->entidadesExternasService->updateEntidadExterna($idEntidadExterna, $data);
    }

    // Eliminar Entidad Externa
    #[Route('/entidadesexternas/{id}', name: 'delete_entidadexterna', methods: ['DELETE'])]
    public function deleteEntidadExterna(int $id): JsonResponse
    {
        return $this->entidadesExternasService->deleteEntidadExterna($id);
    }

}