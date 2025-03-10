<?php

namespace App\Service;

use App\Repository\EntidadExternaRepository;


class EntidadesExternasService{

    private EntidadExternaRepository $entidadExternaRepository;

    public function __construct(EntidadExternaRepository $entidadExternaRepository)
    {
        $this->entidadExternaRepository = $entidadExternaRepository;
    }

    public function getAllEntidadesExternas(): array
    {
        return $this->entidadExternaRepository->findAll();
    }
}