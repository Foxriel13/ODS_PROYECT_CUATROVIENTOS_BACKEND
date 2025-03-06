<?php

namespace App\Service;

use App\Repository\EntidadExternaRepository;


class EntidadesExternasService{

    private EntidadExternaRepository $entidadesExternasRepository;

    public function __construct(EntidadExternaRepository $entidadesExternasRepository)
    {
        $this->entidadesExternasRepository = $entidadesExternasRepository;
    }

    public function getAllEntidadesExternas(): array
    {
        return $this->entidadesExternasRepository->findAll();
    }
}