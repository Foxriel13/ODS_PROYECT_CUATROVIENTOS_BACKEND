<?php

namespace App\Service;

use App\Repository\MODULOSRepository;


class ModulosService{

    private MODULOSRepository $moduloRepository;


    public function __construct(MODULOSRepository $moduloRepository)
    {
        $this->moduloRepository = $moduloRepository;
    }

    public function getAllModulos(): array
    {
        return $this->moduloRepository->findAll();
    }
}