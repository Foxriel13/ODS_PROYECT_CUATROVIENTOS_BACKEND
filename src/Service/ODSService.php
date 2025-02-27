<?php

namespace App\Service;

use App\Repository\ODSRepository;


class ODSService{

    private ODSRepository $odsRepository;

    public function __construct(ODSRepository $odsRepository)
    {
        $this->odsRepository = $odsRepository;
    }

    public function getAllOds(): array
    {
        return $this->odsRepository->findAll();
    }
}