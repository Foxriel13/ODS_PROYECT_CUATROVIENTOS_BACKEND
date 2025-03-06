<?php

namespace App\Service;

use App\Repository\CursoRepository;


class CursosService{

    private CursoRepository $cursoRepository;

    public function __construct(CursoRepository $cursoRepository)
    {
        $this->cursoRepository = $cursoRepository;
    }

    public function getAllCursos(): array
    {
        return $this->cursoRepository->findAll();
    }
}