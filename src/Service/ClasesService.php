<?php

namespace App\Service;

use App\Repository\ClaseRepository;


class ClasesService{

    private ClaseRepository $clasesRepository;

    public function __construct(ClaseRepository $clasesRepository)
    {
        $this->clasesRepository = $clasesRepository;
    }

    public function getAllClases(): array
    {
        return $this->clasesRepository->findAll();
    }
}