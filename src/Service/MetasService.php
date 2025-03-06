<?php

namespace App\Service;

use App\Repository\MetaRepository;


class MetasService{

    private MetaRepository $metasRepository;

    public function __construct(MetaRepository $metasRepository)
    {
        $this->metasRepository = $metasRepository;
    }

    public function getAllMetas(): array
    {
        return $this->metasRepository->findAll();
    }
}