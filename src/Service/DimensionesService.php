<?php

namespace App\Service;

use App\Repository\DIMENSIONRepository;
use App\Entity\DIMENSION;
use Doctrine\ORM\EntityManagerInterface;


class DimensionesService{

    private DIMENSIONRepository $dimensionRepository;

    public function __construct(DIMENSIONRepository $dimensionRepository)
    {
        $this->dimensionRepository = $dimensionRepository;
    }

    public function getAllDimensiones(): array
    {
        return $this->dimensionRepository->findAll();
    }

}