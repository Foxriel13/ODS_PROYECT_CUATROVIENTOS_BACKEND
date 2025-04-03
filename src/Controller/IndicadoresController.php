<?php

namespace App\Controller;

use App\Service\IndicadoresService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class IndicadoresController extends AbstractController
{

    // Constructor con el servicio de la entidad Iniciativa
    public function __construct(private IndicadoresService $indicadoresService)
    {
        $this->indicadoresService = $indicadoresService;
    }

    // GET Indicador 1
    #[Route('/indicadores/iniciativasPorCurso', methods: ['GET'])]
    public function getIniciativasPorCurso(): JsonResponse
    {
        return $this->indicadoresService->getIniciativasPorCurso();
    }

    // GET Indicador 2
    #[Route('/indicadores/cantidadIniciativas', methods: ['GET'])]
    public function getNumeroIniciativas(): JsonResponse
    {
        return $this->indicadoresService->getNumeroIniciativas();
    }

    // GET Indicador 4
    #[Route('/indicadores/explicacionIniciativas', methods: ['GET'])]
    public function getDescripcionIniciativa(): JsonResponse
    {
        return $this->indicadoresService->getDescripcionIniciativa();
    }

    // GET Indicador 6
    #[Route('/indicadores/tieneEntidadesExternas', methods: ['GET'])]
    public function getTieneEntidadesExternas(): JsonResponse
    {
        return $this->indicadoresService->getHaColaboradoEntidadExterna();
    }

    // GET Indicador 7
    #[Route('/indicadores/tieneRRSS', methods: ['GET'])]
    public function getRRSSdeIniciativa(): JsonResponse
    {
        return $this->indicadoresService->getDifusionIniciativas();
    }

    // GET Indicador 8
    #[Route('/indicadores/tipoIniciativa', methods: ['GET'])]
    public function getTiposIniciativas(): JsonResponse
    {
        return $this->indicadoresService->getTipo();
    }
}
