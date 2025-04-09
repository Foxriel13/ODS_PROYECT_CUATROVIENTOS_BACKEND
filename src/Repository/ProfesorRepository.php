<?php

namespace App\Repository;

use App\Entity\Profesor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Profesor>
 */
class ProfesorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Profesor::class);
    }

    public function countIniciativasPorProfesor(): array
    {
        return $this->createQueryBuilder('i')
            ->select('p.nombre AS nombre, COUNT(i.id) AS totalIniciativas')
            ->innerJoin('i.profesores', 'p')
            ->groupBy('p.id')
            ->orderBy('totalIniciativas', 'DESC')
            ->getQuery()
            ->getResult();
    }
    
}
