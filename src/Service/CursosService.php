<?php

namespace App\Service;

use App\Repository\CURSOSRepository;


class CursosService{

    private CURSOSRepository $cursoRepository;

    public function __construct(CursosRepository $cursoRepository)
    {
        $this->cursoRepository = $cursoRepository;
    }

    public function getAllCursos(): array
    {
        return $this->cursoRepository->findAll();
    }
}