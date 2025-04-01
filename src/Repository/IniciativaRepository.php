<?php

namespace App\Repository;

use App\Entity\Clase;
use App\Entity\Iniciativa;
use App\Entity\ODS;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Iniciativa>
 */
class IniciativaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Iniciativa::class);
    }

    public function findByEliminado()
    {
        return $this->findBy(['eliminado' => true]);
    }

    public function findByActivas()
    {
        return $this->findBy(['eliminado' => false]);
    }

    public function findAniosLectivos(): array
    {
        return $this->createQueryBuilder('i')
            ->select('DISTINCT i.anyoLectivo') // Asegura que no haya duplicados
            ->orderBy('i.anyoLectivo', 'DESC')
            ->getQuery()
            ->getSingleColumnResult();
    }

    /**
     * Obtiene el número de iniciativas por año lectivo
     */
    public function countIniciativasPorAnio(): array
    {
        return $this->createQueryBuilder('i')
            ->select('i.anyoLectivo, COUNT(i.id) AS total')
            ->groupBy('i.anyoLectivo')
            ->orderBy('i.anyoLectivo', 'DESC')
            ->getQuery()
            ->getResult();
    }
    

    //    /**
    //     * @return Iniciativa[] Returns an array of Iniciativa objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('i.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Iniciativa
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
