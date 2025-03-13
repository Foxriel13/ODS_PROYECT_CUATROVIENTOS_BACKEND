<?php

namespace App\Controller;

use App\Service\MetasService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MetasController extends AbstractController
{

    // Constructor con el servicio de la entidad Meta
    public function __construct(private MetasService $metasService)
    {
        $this->metasService = $metasService;
    }

    // Get de las Metas
    #[Route('/metas', name: 'metas', methods: ['GET'])]
    public function getMetas(): JsonResponse
    {
        $metas = $this->metasService->getAllMetas();
        return $this->json($metas);
    }
    
}