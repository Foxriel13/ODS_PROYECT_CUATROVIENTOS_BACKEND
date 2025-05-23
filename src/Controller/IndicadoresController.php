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

    // GET Indicador 3
    #[Route('/indicadores/ciclosYModulosConInciativas', methods: ['GET'])]
    public function getCiclosYModulosConIniciativas(): JsonResponse
    {
        return $this->indicadoresService->getCiclosYModulosConIniciativas();
    }

    // GET Indicador 4
    #[Route('/indicadores/explicacionIniciativas', methods: ['GET'])]
    public function getDescripcionIniciativa(): JsonResponse
    {
        return $this->indicadoresService->getDescripcionIniciativa();
    }

    // GET Indicador 5
    #[Route('/indicadores/odsTrabajadosYSusMetas', methods: ['GET'])]
    public function getODStrabajadosYSusMetas(): JsonResponse
    {
        return $this->indicadoresService->getODStrabajadosYSusMetas();
    }

    // GET Indicador 6
    #[Route('/indicadores/tieneEntidadesExternas', methods: ['GET'])]
    public function getTieneEntidadesExternas(): JsonResponse
    {
        return $this->indicadoresService->getTieneEntidadesExternas();
    }

    // GET Indicador 7
    #[Route('/indicadores/tieneRRSS', methods: ['GET'])]
    public function getRRSSdeIniciativa(): JsonResponse
    {
        return $this->indicadoresService->getRRSSdeIniciativa();
    }

    // GET Indicador 8
    #[Route('/indicadores/tipoIniciativa', methods: ['GET'])]
    public function getTiposIniciativas(): JsonResponse
    {
        return $this->indicadoresService->getTiposIniciativas();
    }

    // TODO: GET Indicador 9

    // GET Indicador 10.1
    #[Route('/indicadores/cantProfesores', methods: ['GET'])]
    public function getCantidadProfesores(): JsonResponse
    {
        return $this->indicadoresService->getCantidadProfesores();
    }

    // GET Indicador 10.2
    #[Route('/indicadores/cantIniciativasProfesor', methods: ['GET'])]
    public function getCantidadDeIniciativasPorProfesor(): JsonResponse
    {
        return $this->indicadoresService->getCantidadDeIniciativasPorProfesor();
    }

    // GET Indicador 11
    #[Route('/indicadores/diferenciaInnovadoresYNo', methods: ['GET'])]
    public function getDiferenciaInnovadoras(): JsonResponse
    {
        return $this->indicadoresService->getDiferenciaInnovadoras();
    }

    // GET Indicador 12
    #[Route('/indicadores/cantHorasIniciativa', methods: ['GET'])]
    public function getHorasActividad(): JsonResponse
    {
        return $this->indicadoresService->getHorasActividad();
    }

    // TODO: GET Indicador 13
    #[Route('/indicadores/haTendioActividad', methods: ['GET'])]
    public function getIniciativasActividad(): JsonResponse
    {
        return $this->indicadoresService->getIniciativasActividad();
    }
}
