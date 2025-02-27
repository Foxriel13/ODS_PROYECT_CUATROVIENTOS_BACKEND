<?php

namespace App\Service;

use App\Repository\METASRepository;


class MetasService{

    private METASRepository $metasRepository;

    public function __construct(METASRepository $metasRepository)
    {
        $this->metasRepository = $metasRepository;
    }

    public function getAllMetas(): array
    {
        return $this->metasRepository->findAll();
    }
}