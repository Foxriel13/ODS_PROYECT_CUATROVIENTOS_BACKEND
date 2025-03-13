<?php

namespace App\Controller;

use App\Service\EntidadesExternasService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

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
    
}