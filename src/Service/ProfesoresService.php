<?php

namespace App\Service;

use App\Repository\PROFESORESRepository;


class ProfesoresService{

    private PROFESORESRepository $profesoresRepository;

    public function __construct(PROFESORESRepository $profesoresRepository)
    {
        $this->profesoresRepository = $profesoresRepository;
    }

    public function getAllProfesores(): array
    {
        return $this->profesoresRepository->findAll();
    }
}