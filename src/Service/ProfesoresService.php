<?php

namespace App\Service;

use App\Repository\ProfesorRepository;


class ProfesoresService{

    private ProfesorRepository $profesoresRepository;

    public function __construct(ProfesorRepository $profesoresRepository)
    {
        $this->profesoresRepository = $profesoresRepository;
    }

    public function getAllProfesores(): array
    {
        return $this->profesoresRepository->findAll();
    }
}