<?php

namespace App\Service;

use App\Repository\ENTIDADESEXTERNASRepository;


class EntidadesExternasService{

    private ENTIDADESEXTERNASRepository $entidadesExternasRepository;

    public function __construct(ENTIDADESEXTERNASRepository $entidadesExternasRepository)
    {
        $this->entidadesExternasRepository = $entidadesExternasRepository;
    }

    public function getAllEntidadesExternas(): array
    {
        return $this->entidadesExternasRepository->findAll();
    }
}