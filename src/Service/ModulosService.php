<?php

namespace App\Service;

use App\Repository\ModuloRepository;


class ModulosService{

    private ModuloRepository $moduloRepository;


    public function __construct(ModuloRepository $moduloRepository)
    {
        $this->moduloRepository = $moduloRepository;
    }

    public function getAllModulos(): array
    {
        return $this->moduloRepository->findAll();
    }
}