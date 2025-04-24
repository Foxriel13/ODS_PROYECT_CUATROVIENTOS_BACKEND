<?php

namespace App\Repository;

use App\Entity\IniciativaRedesSociales;
use App\Entity\IniciativaRedSocial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<IniciativaRedesSociales>
 */
class IniciativaRedSocialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IniciativaRedSocial::class);
    }

}
