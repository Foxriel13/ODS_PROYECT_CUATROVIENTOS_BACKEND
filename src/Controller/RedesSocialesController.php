<?php

namespace App\Controller;

use App\Service\RedesSocialesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RedesSocialesController extends AbstractController
{

    // Constructor con el servicio de la entidad Profesor
    public function __construct(private RedesSocialesService $redesSocialesService)
    {
        $this->redesSocialesService = $redesSocialesService;
    }

    // Get de las Redes
    #[Route('/redes_sociales', name: 'redesSociales', methods: ['GET'])]
    public function getRedesSociales(): JsonResponse
    {
        return $this->redesSocialesService->getAllRedes();
    }
    
    // Crear Red Social
    #[Route('/redes_sociales', methods: ['POST'])]
    public function createRedSocial(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        if (!is_array($data)) {
            return new JsonResponse(
                ['message' => 'Datos inválidos o formato incorrecto'],
                Response::HTTP_BAD_REQUEST
            );
        }
    
        return $this->redesSocialesService->createRedSocial($data);
    }

    // Actualizar Profesor
    #[Route('/redes_sociales/{idRedSocial}', methods: ['PUT'])]
    public function updateRedSocial(Request $request, int $idRedSocial): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        if (!$data) {
            return new JsonResponse(['message' => 'Datos inválidos'], Response::HTTP_BAD_REQUEST);
        }
    
        return $this->redesSocialesService->updateRedSocial($idRedSocial, $data);
    }

    // Eliminar Profesor
    #[Route('/redes_sociales/{id}', name: 'delete_red_social', methods: ['DELETE'])]
    public function deleteRedSocial(int $id): JsonResponse
    {
        return $this->redesSocialesService->deleteRedSocial($id);
    }

}