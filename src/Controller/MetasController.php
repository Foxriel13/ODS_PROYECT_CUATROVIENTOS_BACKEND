<?php

namespace App\Controller;

use App\Service\MetasService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MetasController extends AbstractController
{
    private MetasService $metasService;

    public function __construct(MetasService $metasService)
    {
        $this->metasService = $metasService;
    }

    #[Route('/metas', name: 'metas', methods: ['GET'])]
    public function getMetas(): JsonResponse
    {
        $metas = $this->metasService->getAllMetas();
        return $this->json($metas);
    }
}