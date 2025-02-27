<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Service\IniciativaService;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Intl\Data\Bundle\Writer\JsonBundleWriter;
use Symfony\Component\Routing\Attribute\Route;

final class IniciativaController extends AbstractController
{
    private IniciativaService $iniciativaService;

    public function __construct(IniciativaService $iniciativaService)
    {
        $this->iniciativaService = $iniciativaService;
    }

    #[Route('/iniciativas', methods: ['GET'])]
    public function searchIniciativas(Request $request): JsonResponse
    {
        $eliminado = $request->query->get('eliminado');

        if ($eliminado == 'true') {
            return $this->iniciativaService->getIniciativasEliminadas();
        }elseif ($eliminado == 'false') {
            return $this->iniciativaService->getIniciativasActivas();
        }else{
            return $this->iniciativaService->getIniciativas();    
        }

    }

}
