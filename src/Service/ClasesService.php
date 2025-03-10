<?php

namespace App\Service;

use App\Repository\CLASESRepository;


class ClasesService{

    private CLASESRepository $clasesRepository;

    public function __construct(CLASESRepository $clasesRepository)
    {
        $this->clasesRepository = $clasesRepository;
    }

    public function getAllClases(): array
    {
        return $this->clasesRepository->findAll();
    }
}