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
    #[Route('/indicadores/iniciativasPorCurso/{idCurso}', methods: ['GET'])]
    public function getIniciativasPorCurso(int $idCurso): JsonResponse
    {
        return $this->indicadoresService->getIniciativasPorCurso($idCurso);    
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
    #[Route('/indicadores/tieneEntidadesExternas/{id}', methods: ['GET'])]
    public function getHaColaboradoEntidadExterna(int $id): JsonResponse
    {
        return $this->indicadoresService->getHaColaboradoEntidadExterna($id);    
    } 


    // GET Indicador 7
    #[Route('/indicadores/haColaboradoEntidadExterna/{id}', methods: ['GET'])]
    public function getRedesSociales(int $id): JsonResponse
    {
        return $this->indicadoresService->getRedesSociales($id);    
    } 
    
}