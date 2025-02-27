<?php

namespace App\Controller;

use App\Service\ODSService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ODSController extends AbstractController
{
    private ODSService $odsService;

    public function __construct(ODSService $odsService)
    {
        $this->odsService = $odsService;
    }

    #[Route('/ods', name: 'ods', methods: ['GET'])]
    public function getCursos(): JsonResponse
    {
        $cursos = $this->odsService->getAllOds();
        return $this->json($cursos);
    }
}