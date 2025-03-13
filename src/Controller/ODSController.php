<?php

namespace App\Controller;

use App\Service\ODSService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

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
    
}