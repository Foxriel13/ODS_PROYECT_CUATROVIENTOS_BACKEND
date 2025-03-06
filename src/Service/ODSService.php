<?php

namespace App\Service;

use App\Repository\OdsRepository;


class ODSService{

    private OdsRepository $odsRepository;

    public function __construct(OdsRepository $odsRepository)
    {
        $this->odsRepository = $odsRepository;
    }

    public function getAllOds(): array
    {
        return $this->odsRepository->findAll();
    }
}