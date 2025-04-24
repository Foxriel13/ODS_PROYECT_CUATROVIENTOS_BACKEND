<?php

namespace App\Controller;

use App\Service\ModulosService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ModulosController extends AbstractController
{

    // Constructor con el servicio de la entidad Meta
    public function __construct(private ModulosService $modulosService)
    {
        $this->modulosService = $modulosService;
    }

    // Get de las Modulos
    #[Route('/modulos', name: 'get_modulos', methods: ['GET'])]
    public function getModulos(): JsonResponse
    {
        return $this->modulosService->getAllModulos();
    }
    
   // Crear Modulo
   #[Route('/modulos', name: 'create_modulo', methods: ['POST'])]
   public function createModulo(Request $request): JsonResponse
   {
       $data = json_decode($request->getContent(), true);
  
       if (!is_array($data)) {
           return new JsonResponse(
               ['message' => 'Datos inválidos o formato incorrecto'],
               Response::HTTP_BAD_REQUEST
           );
       }
  
       return $this->modulosService->createModulo($data);
   }

   // Actualizar Modulo
   #[Route('/modulos/{idModulo}', name: 'update_modulo', methods: ['PUT'])]
   public function updateMeta(Request $request, int $idModulo): JsonResponse
   {
       $data = json_decode($request->getContent(), true);
  
       if (!$data) {
           return new JsonResponse(['message' => 'Datos inválidos'], Response::HTTP_BAD_REQUEST);
       }
  
       return $this->modulosService->updateModulo($idModulo, $data);
   }

   // Eliminar Modulo
   #[Route('/modulos/{idModulo}', name: 'delete_modulo', methods: ['DELETE'])]
   public function deleteModulo(int $idModulo): JsonResponse
   {
       return $this->modulosService->deleteModulo($idModulo);
   }

}