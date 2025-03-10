<?php

namespace App\Service;

use App\Repository\DimensionRepository;

class DimensionesService{

    private DimensionRepository $dimensionRepository;

    public function __construct(DimensionRepository $dimensionRepository)
    {
        $this->dimensionRepository = $dimensionRepository;
    }

    public function getAllDimensiones(): array
    {
        return $this->dimensionRepository->findAll();
    }

}