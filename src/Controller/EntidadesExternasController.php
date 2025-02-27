<?php

namespace App\Controller;

use App\Service\EntidadesExternasService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class EntidadesExternasController extends AbstractController
{
    private EntidadesExternasService $entidadesExternasService;

    public function __construct(EntidadesExternasService $entidadesExternasService)
    {
        $this->entidadesExternasService = $entidadesExternasService;
    }

    #[Route('/entidadesexternas', name: 'entidadesExternas', methods: ['GET'])]
    public function getEntidadesExternas(): JsonResponse
    {
        $entidadesExternas = $this->entidadesExternasService->getAllEntidadesExternas();
        return $this->json($entidadesExternas);
    }
}