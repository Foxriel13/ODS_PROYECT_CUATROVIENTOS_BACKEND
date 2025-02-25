<?php

namespace App\Repository;

use App\Entity\ENTIDADESEXTERNASINICIATIVAS;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ENTIDADESEXTERNASINICIATIVAS>
 */
class ENTIDADESEXTERNASINICIATIVASRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ENTIDADESEXTERNASINICIATIVAS::class);
    }

    //    /**
    //     * @return ENTIDADESEXTERNASINICIATIVAS[] Returns an array of ENTIDADESEXTERNASINICIATIVAS objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ENTIDADESEXTERNASINICIATIVAS
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
